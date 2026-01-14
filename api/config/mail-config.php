<?php
/**
 * Configuración de PHPMailer
 *
 * Retorna una instancia configurada de PHPMailer
 *
 * @return PHPMailer\PHPMailer\PHPMailer
 * @throws Exception
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function getMailerInstance() {
    $mail = new PHPMailer(true);

    try {
        // ========================================
        // CONFIGURACIÓN DEL SERVIDOR SMTP
        // ========================================
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
        $mail->Port = (int)$_ENV['SMTP_PORT'];

        // ========================================
        // CONFIGURACIÓN DE DEBUG
        // ========================================
        // Siempre desactivar debug output para no romper JSON
        // Los errores se capturan en los logs de la aplicación
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        // ========================================
        // CONFIGURACIÓN DE FORMATO
        // ========================================
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // ========================================
        // OPCIONES DE SEGURIDAD
        // ========================================
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => false
            ]
        ];

        return $mail;

    } catch (Exception $e) {
        throw new Exception("Error al configurar PHPMailer: {$e->getMessage()}");
    }
}
