<?php
/**
 * Funciones de validación de datos del formulario
 *
 * @package Landing Page Dr. Aldo Avellaneda
 */

/**
 * Validar nombre completo
 * Mínimo 3 caracteres, solo letras y espacios
 *
 * @param string $name
 * @return bool
 */
function validateName($name) {
    if (strlen($name) < 3) {
        return false;
    }

    // Permitir letras (incluyendo acentos), espacios, guiones y apóstrofes
    return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-']+$/u", $name);
}

/**
 * Validar email
 *
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validar teléfono
 * Acepta formato internacional con +, números, espacios, guiones y paréntesis
 *
 * @param string $phone
 * @return bool
 */
function validatePhone($phone) {
    // Remover espacios para contar dígitos
    $digitsOnly = preg_replace('/[^\d]/', '', $phone);

    // Mínimo 10 dígitos
    if (strlen($digitsOnly) < 10) {
        return false;
    }

    // Formato: +, dígitos, espacios, guiones, paréntesis
    return preg_match("/^[\+\d\s\-\(\)]+$/", $phone);
}

/**
 * Validar idioma preferido
 *
 * @param string $language
 * @return bool
 */
function validateLanguage($language) {
    return in_array($language, ['spanish', 'english']);
}

/**
 * Validar mensaje
 * Mínimo 10 caracteres
 *
 * @param string $message
 * @return bool
 */
function validateMessage($message) {
    return strlen($message) >= 10;
}
