<?php
/**
 * Endpoint para procesamiento de solicitudes de citas médicas
 *
 * Acepta: POST con JSON
 * Retorna: JSON con status y mensaje
 *
 * @package Landing Page Dr. Aldo Avellaneda
 * @version 1.0.0
 */

// Habilitar display de errores solo en desarrollo
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Headers de seguridad
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Configurar Content-Type para JSON
header('Content-Type: application/json; charset=utf-8');

// Cargar autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Cargar funciones auxiliares
require_once __DIR__ . '/includes/validation.php';
require_once __DIR__ . '/includes/sanitization.php';
require_once __DIR__ . '/config/mail-config.php';

/**
 * Función para enviar respuesta JSON y terminar ejecución
 */
function sendJsonResponse($success, $message, $data = [], $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('c')
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Función para logging de errores
 */
function logError($message, $context = []) {
    $logDir = __DIR__ . '/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $logFile = $logDir . '/errors-' . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? json_encode($context) : '';
    $logMessage = "[$timestamp] $message $contextStr\n";

    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// ========================================
// 1. CONFIGURAR CORS
// ========================================
$allowedOrigins = $_ENV['DEV_MODE'] === 'true'
    ? explode(',', $_ENV['ALLOWED_ORIGINS_DEV'])
    : explode(',', $_ENV['ALLOWED_ORIGINS_PROD']);

// Limpiar espacios en blanco
$allowedOrigins = array_map('trim', $allowedOrigins);

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: {$allowedOrigins[0]}");
}

header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400'); // 24 horas

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ========================================
// 2. VALIDAR MÉTODO HTTP
// ========================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Método no permitido. Solo se acepta POST.', [], 405);
}

// ========================================
// 3. RATE LIMITING SIMPLE
// ========================================
session_start();
$clientIp = $_SERVER['REMOTE_ADDR'];
$sessionKey = "rate_limit_$clientIp";
$maxAttempts = (int)$_ENV['MAX_ATTEMPTS_PER_HOUR'];
$timeWindow = 3600; // 1 hora

if (!isset($_SESSION[$sessionKey])) {
    $_SESSION[$sessionKey] = [
        'count' => 0,
        'first_attempt' => time()
    ];
}

$rateLimitData = $_SESSION[$sessionKey];

// Resetear si pasó el tiempo
if (time() - $rateLimitData['first_attempt'] > $timeWindow) {
    $_SESSION[$sessionKey] = [
        'count' => 0,
        'first_attempt' => time()
    ];
    $rateLimitData = $_SESSION[$sessionKey];
}

// Verificar límite
if ($rateLimitData['count'] >= $maxAttempts) {
    logError('Rate limit excedido', ['ip' => $clientIp]);
    sendJsonResponse(
        false,
        'Has excedido el límite de solicitudes. Por favor intenta más tarde.',
        [],
        429
    );
}

// Incrementar contador
$_SESSION[$sessionKey]['count']++;

// ========================================
// 4. OBTENER Y DECODIFICAR DATOS
// ========================================
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    logError('Error al decodificar JSON', ['error' => json_last_error_msg()]);
    sendJsonResponse(false, 'Datos inválidos. No se pudo procesar el JSON.', [], 400);
}

// ========================================
// 5. VALIDAR CAMPOS REQUERIDOS
// ========================================
$requiredFields = ['fullName', 'email', 'phone', 'preferredLanguage', 'message'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || trim($data[$field]) === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    sendJsonResponse(
        false,
        'Faltan campos requeridos: ' . implode(', ', $missingFields),
        ['missing_fields' => $missingFields],
        400
    );
}

// ========================================
// 6. SANITIZAR DATOS
// ========================================
$fullName = sanitizeString($data['fullName']);
$email = sanitizeEmail($data['email']);
$phone = sanitizePhone($data['phone']);
$preferredLanguage = sanitizeString($data['preferredLanguage']);
$message = sanitizeMessage($data['message']);

// ========================================
// 7. VALIDAR DATOS
// ========================================
$errors = [];

if (!validateName($fullName)) {
    $errors[] = 'El nombre debe tener al menos 3 caracteres.';
}

if (!validateEmail($email)) {
    $errors[] = 'El correo electrónico no es válido.';
}

if (!validatePhone($phone)) {
    $errors[] = 'El número de teléfono no es válido.';
}

if (!validateLanguage($preferredLanguage)) {
    $errors[] = 'El idioma preferido no es válido. Solo se acepta "spanish" o "english".';
}

if (!validateMessage($message)) {
    $errors[] = 'El mensaje debe tener al menos 10 caracteres.';
}

if (!empty($errors)) {
    sendJsonResponse(false, 'Errores de validación', ['errors' => $errors], 400);
}

// ========================================
// 8. ENVIAR EMAILS
// ========================================
try {
    // ========== EMAIL 1: NOTIFICACIÓN AL RECEPTOR ==========
    $notificationMail = getMailerInstance();

    // Destinatarios
    $notificationMail->setFrom(
        $_ENV['MAIL_FROM_ADDRESS'],
        $_ENV['MAIL_FROM_NAME']
    );
    $notificationMail->addAddress(
        $_ENV['MAIL_TO_ADDRESS'],
        $_ENV['MAIL_TO_NAME']
    );
    $notificationMail->addReplyTo($email, $fullName);

    // Asunto según idioma
    $subjectNotification = $preferredLanguage === 'spanish'
        ? $_ENV['EMAIL_SUBJECT_NOTIFICATION_ES']
        : $_ENV['EMAIL_SUBJECT_NOTIFICATION_EN'];
    $notificationMail->Subject = $subjectNotification;

    // Cargar plantilla HTML según idioma
    $templateFileNotification = $preferredLanguage === 'spanish'
        ? __DIR__ . '/templates/email-notification-es.php'
        : __DIR__ . '/templates/email-notification-en.php';

    ob_start();
    include $templateFileNotification;
    $htmlBodyNotification = ob_get_clean();

    $notificationMail->Body = $htmlBodyNotification;
    $notificationMail->AltBody = strip_tags($htmlBodyNotification);

    // Enviar email de notificación
    if (!$notificationMail->send()) {
        throw new Exception('Error al enviar email de notificación: ' . $notificationMail->ErrorInfo);
    }

    // ========== EMAIL 2: CONFIRMACIÓN AL USUARIO ==========
    $confirmationMail = getMailerInstance();

    $confirmationMail->setFrom(
        $_ENV['MAIL_FROM_ADDRESS'],
        $_ENV['MAIL_FROM_NAME']
    );
    $confirmationMail->addAddress($email, $fullName);
    $confirmationMail->addReplyTo($_ENV['MAIL_REPLY_TO_ADDRESS']);

    // Asunto según idioma
    $subjectConfirmation = $preferredLanguage === 'spanish'
        ? $_ENV['EMAIL_SUBJECT_CONFIRMATION_ES']
        : $_ENV['EMAIL_SUBJECT_CONFIRMATION_EN'];
    $confirmationMail->Subject = $subjectConfirmation;

    // Cargar plantilla HTML según idioma
    $templateFileConfirmation = $preferredLanguage === 'spanish'
        ? __DIR__ . '/templates/email-confirmation-es.php'
        : __DIR__ . '/templates/email-confirmation-en.php';

    ob_start();
    include $templateFileConfirmation;
    $htmlBodyConfirmation = ob_get_clean();

    $confirmationMail->Body = $htmlBodyConfirmation;
    $confirmationMail->AltBody = strip_tags($htmlBodyConfirmation);

    // Enviar email de confirmación
    if (!$confirmationMail->send()) {
        throw new Exception('Error al enviar email de confirmación: ' . $confirmationMail->ErrorInfo);
    }

    // ========================================
    // 9. RESPUESTA EXITOSA
    // ========================================
    logError('Emails enviados exitosamente', [
        'email' => $email,
        'name' => $fullName,
        'language' => $preferredLanguage
    ]);

    $successMessage = $preferredLanguage === 'spanish'
        ? 'Solicitud enviada exitosamente. Una asesora quirúrgica se comunicará con usted pronto.'
        : 'Request sent successfully. A nurse coordinator will contact you shortly.';

    sendJsonResponse(true, $successMessage, [], 200);

} catch (Exception $e) {
    logError('Error al procesar solicitud', [
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'email' => $email ?? 'unknown'
    ]);

    // Mensaje genérico en producción
    $errorMessage = $_ENV['DEV_MODE'] === 'true'
        ? 'Error técnico: ' . $e->getMessage()
        : 'Error al procesar la solicitud. Por favor intenta más tarde o contacta directamente.';

    sendJsonResponse(false, $errorMessage, [], 500);
}
