<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validarAutenticacionCentral() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Si ya hay sesión activa con el formato nuevo
    if (!empty($_SESSION['user_id'])) {
        return true;
    }

    // Validar token en GET
    if (!empty($_GET['token'])) {
        try {
            $key = 'cedhi2024biblio';
            $decoded = JWT::decode($_GET['token'], new Key($key, 'HS256'));
            $userData = (array) $decoded;

            // Guardar SOLO en formato estandarizado
            $_SESSION = array_merge($_SESSION, [
                'user_id'    => $userData['userId'],
                'user_email' => $userData['email'],
                'user_name'  => $userData['nombre'],
                'user_last'  => $userData['apellido'],
                'role'       => strtolower($userData['rol'])
            ]);

            return true;
        } catch (Exception $e) {
            error_log("❌ AUTH_CENTRAL: Error JWT -> " . $e->getMessage());
        }
    }

    return false;
}

function obtenerUsuarioCentral() {
    return validarAutenticacionCentral() ? [
        'id'       => $_SESSION['user_id']    ?? null,
        'email'    => $_SESSION['user_email'] ?? null,
        'nombre'   => $_SESSION['user_name']  ?? null,
        'apellido' => $_SESSION['user_last']  ?? null,
        'rol'      => $_SESSION['role']       ?? null
    ] : null;
}
?>
