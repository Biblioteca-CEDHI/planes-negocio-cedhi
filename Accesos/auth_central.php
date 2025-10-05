<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validarAutenticacionCentral() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Si ya hay sesión activa con datos válidos
    if (!empty($_SESSION['user_id'])) {
        return true;
    }

    // Validar token si viene en GET
    if (!empty($_GET['token'])) {
        try {
            $key = 'cedhi2024biblio';
            $decoded = JWT::decode($_GET['token'], new Key($key, 'HS256'));
            $userData = (array) $decoded;

            // 🔍 Log de depuración
            //error_log("DEBUG - Token Data (decoded): " . print_r($userData, true));

            // Guardar en sesión con los mismos nombres usados en generateToken()
            $_SESSION['user_id']             = $userData['userId'] ?? null;
            $_SESSION['user_email_address']  = $userData['email'] ?? null;
            $_SESSION['user_first_name']     = $userData['nombre'] ?? null;
            $_SESSION['user_last_name']      = $userData['apellido'] ?? null;
            $_SESSION['role']                = strtolower($userData['rol'] ?? '');

            return true;
        } catch (Exception $e) {
            error_log("❌ AUTH_CENTRAL: Error JWT -> " . $e->getMessage());
        }
    }

    return false;
}

function obtenerUsuarioCentral() {
    if (!validarAutenticacionCentral()) {
        return null;
    }

    return [
        'id'       => $_SESSION['user_id'] ?? null,
        'email'    => $_SESSION['user_email_address'] ?? null,
        'nombre'   => $_SESSION['user_first_name'] ?? null,
        'apellido' => $_SESSION['user_last_name'] ?? null,
        'rol'      => $_SESSION['role'] ?? null
    ];
}
?>
