<?php
/**
 * Funciones de sanitización de datos
 *
 * @package Landing Page Dr. Aldo Avellaneda
 */

/**
 * Sanitizar string general
 * Remueve tags HTML, caracteres especiales
 *
 * @param string $input
 * @return string
 */
function sanitizeString($input) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

/**
 * Sanitizar email
 *
 * @param string $email
 * @return string
 */
function sanitizeEmail($email) {
    $email = trim($email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return strtolower($email);
}

/**
 * Sanitizar teléfono
 * Remueve caracteres no permitidos
 *
 * @param string $phone
 * @return string
 */
function sanitizePhone($phone) {
    $phone = trim($phone);
    // Solo permitir +, dígitos, espacios, guiones, paréntesis
    $phone = preg_replace('/[^\+\d\s\-\(\)]/', '', $phone);
    return $phone;
}

/**
 * Sanitizar mensaje largo (textarea)
 * Permite saltos de línea pero remueve HTML
 *
 * @param string $message
 * @return string
 */
function sanitizeMessage($message) {
    $message = trim($message);
    $message = strip_tags($message);
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    return $message;
}
