<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validarAutenticacionCentral() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_GET['token'])) {
        try {
            $key = 'cedhi2024biblio';
            $decoded = JWT::decode($_GET['token'], new Key($key, 'HS256'));
            $userData = (array) $decoded;

            // Reiniciar sesión anterior
            //session_unset();

            $_SESSION['user_id']             = $userData['userId'] ?? null;
            $_SESSION['user_email_address']  = $userData['email'] ?? null;
            $_SESSION['user_first_name']     = $userData['nombre'] ?? null;
            $_SESSION['user_last_name']      = $userData['apellido'] ?? null;
            $_SESSION['role']                = strtolower($userData['rol'] ?? '');

            return true;
        } catch (Exception $e) {
            error_log("AUTH_CENTRAL: Error JWT -> " . $e->getMessage());
            return false;
        }
    }

    if (!empty($_SESSION['user_id'])) {
        return true;
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
