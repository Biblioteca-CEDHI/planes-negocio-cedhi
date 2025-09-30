<?php
// ✅ INCLUIR AUTENTICACIÓN CENTRAL CON RUTA CORRECTA
include_once "../Accesos/auth_central.php";

// ✅ VERIFICAR AUTENTICACIÓN CENTRAL Y REDIRIGIR INMEDIATAMENTE
if (!validarAutenticacionCentral()) {
    header("Location: http://localhost/BibliotecaCEDHI/");
    exit();
}

// ✅ OBTENER DATOS DEL USUARIO
$usuarioData = obtenerUsuarioCentral();
$rol = $usuarioData['rol'];

// ✅ VALIDACIÓN DE ACCESO: Solo 'Administrador' o 'Owner' pueden eliminar tesis
if ($rol !== 'admin' && $rol !== 'owner') {
    header("Location: http://localhost/BibliotecaCEDHI/?error=permisos");
    exit();
}

// ✅ INICIAR SESIÓN PARA COMPATIBILIDAD CON CÓDIGO EXISTENTE
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['rol'] = $rol;
$_SESSION['usuario_id'] = $usuarioData['id'];

// ✅ INCLUIR CONEXIÓN A LA BASE DE DATOS
include_once "../Conection/conexion.php";

// ✅ CREAR CONEXIÓN A LA BASE DE DATOS
$conn = new mysqli($servername, $username, $password, $dbname);

// ✅ VERIFICAR CONEXIÓN
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// ✅ VERIFICAR SI SE RECIBIÓ EL ID POR LA URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ✅ CONSULTA PREPARADA PARA EVITAR INYECCIONES SQL
    $sql = "DELETE FROM Tesis WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // ✅ EJECUTAR CONSULTA
    if ($stmt->execute()) {
        // ✅ REDIRIGIR A GESTIÓN DE TESIS SI FUE EXITOSO
        header("Location: gestionar_tesis.php");
        exit();
    } else {
        // ✅ MOSTRAR ERROR SI FALLA LA ELIMINACIÓN
        echo "Error al eliminar la tesis: " . $conn->error;
    }
} else {
    // ✅ ERROR SI NO SE ESPECIFICÓ ID
    die("ID de tesis no especificado.");
}

// ✅ CERRAR CONEXIÓN
$conn->close();
?>