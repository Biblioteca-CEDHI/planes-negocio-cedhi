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

// ✅ VALIDACIÓN DE ACCESO: Solo 'Administrador' y 'Owner' pueden gestionar tesis
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

/*----------------------------------------------------------
| Consulta para obtener todas las tesis y su carrera asociada
-----------------------------------------------------------*/
$sql = "SELECT t.*, c.Nombre AS NombreCarrera
        FROM Tesis t
        JOIN Carrera c ON t.Carrera_ID = c.ID
        ORDER BY t.ID DESC";  // Orden descendente para mostrar primero las más recientes

$result = $conn->query($sql);

// Si hubo error al hacer la consulta SQL
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Plan de Negocios</title>
    <!-- Incluimos Bootstrap para estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <style>
        body { padding: 20px; background: #f4f4f4; }
        .table thead { background: #6a82fb; color: white; }
        .user-info {
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .admin-badge {
            background-color: #6a82fb;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .owner-badge {
            background-color: #ffc107;
            color: #000;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- ✅ INFORMACIÓN DEL USUARIO -->
    <div class="user-info">
        <h4 class="mb-2">
            <i class="fas fa-user-shield"></i> Panel de Administración
            <?php if ($rol === 'owner'): ?>
                <span class="owner-badge ms-2">OWNER</span>
            <?php else: ?>
                <span class="admin-badge ms-2">ADMINISTRADOR</span>
            <?php endif; ?>
        </h4>
        <p class="mb-0">Usuario: <strong><?= htmlspecialchars($usuarioData['nombre'] . ' ' . $usuarioData['apellido']) ?></strong></p>
    </div>

    <h2 class="mb-4">Gestión de Plan de Negocios</h2>

    <!-- Botones para navegación -->
    <div class="d-flex justify-content-between mb-3">
        <a href="../index.php" class="btn btn-success">
            <i class="fas fa-home"></i> Volver a INICIO
        </a>
        <a href="ingresar_tesis.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Ingresar Nuevo Plan de Negocios
        </a>
    </div>

    <p><strong>Las tesis están ordenadas del más reciente al más antiguo.</strong></p>

    <!-- Tabla de tesis -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Estado</th>
                <th>Resumen</th>
                <th>Fecha Publicación</th>
                <th>Archivo PDF</th>
                <th>Carrera</th>
                <th>Palabras Clave</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Obtener las palabras clave asociadas a la tesis actual
                    $tesis_id = $row['ID'];

                    // Consulta para obtener las palabras clave de la tesis
                    $sql_palabras = "SELECT Palabra FROM PalabraClave
                                     JOIN TesisPalabraClave ON PalabraClave.ID = TesisPalabraClave.PalabraClave_ID
                                     WHERE TesisPalabraClave.Tesis_ID = ?";
                    $stmt_palabras = $conn->prepare($sql_palabras);
                    $stmt_palabras->bind_param("i", $tesis_id);
                    $stmt_palabras->execute();
                    $result_palabras = $stmt_palabras->get_result();

                    // Guardar todas las palabras clave en un array
                    $palabras_clave = [];
                    while ($row_palabra = $result_palabras->fetch_assoc()) {
                        $palabras_clave[] = $row_palabra['Palabra'];
                    }

                    // Convertir el array de palabras clave a un string separado por comas
                    $lista_palabras = implode(", ", $palabras_clave);
                    ?>

                    <!-- Fila de la tabla para cada tesis -->
                    <tr>
                        <td><?= $row['ID'] ?></td>
                        <td><?= htmlspecialchars($row['Titulo']) ?></td>
                        <td>
                            <span class="badge 
                                <?= $row['Estado'] == 'Aprobado' ? 'bg-success' : 
                                   ($row['Estado'] == 'Pendiente' ? 'bg-warning' : 'bg-secondary') ?>">
                                <?= htmlspecialchars($row['Estado']) ?>
                            </span>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['Resumen'])) ?></td>
                        <td><?= $row['Fecha_publicacion'] ?></td>
                        <td>
                            <?php if (!empty($row['Archivo_pdf'])): ?>
                                <!-- Enlace al PDF -->
                                <a href="../Archivos/<?= htmlspecialchars($row['Archivo_pdf']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-file-pdf"></i> Ver PDF
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No disponible</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['NombreCarrera']) ?></td>
                        <td><?= htmlspecialchars($lista_palabras) ?></td>
                        <td>
                            <!-- Botones para modificar o eliminar la tesis -->
                            <a href="modificar_tesis.php?id=<?= $row['ID'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Modificar
                            </a>
                            <a href="eliminar_tesis.php?id=<?= $row['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta tesis?');">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Mensaje si no hay tesis registradas -->
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i><br>
                        No hay planes de negocio registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Incluimos Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>