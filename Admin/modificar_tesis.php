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

// ✅ VALIDACIÓN DE ACCESO: Solo 'Administrador' y 'Owner' pueden modificar tesis
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

// ✅ VERIFICAR SI EL ID DE LA TESIS FUE RECIBIDO POR GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ✅ PREPARAR Y EJECUTAR CONSULTA PARA OBTENER LOS DATOS DE LA TESIS ESPECÍFICA
    $sql = "SELECT * FROM Tesis WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);  // Protección contra inyección SQL
    $stmt->execute();
    $result = $stmt->get_result();

    // ✅ SI LA TESIS EXISTE, ALMACENAR SUS DATOS
    if ($result->num_rows > 0) {
        $tesis = $result->fetch_assoc();
    } else {
        die("Plan de negocio no encontrado.");
    }

    // ✅ SI EL FORMULARIO FUE ENVIADO POR MÉTODO POST (ACTUALIZAR)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos enviados por el formulario
        $titulo = $_POST['titulo'];
        $estado = $_POST['estado'];
        $resumen = $_POST['resumen'];
        $fecha_publicacion = $_POST['fecha_publicacion'];
        $carrera_id = $_POST['carrera_id'];

        // ✅ PREPARAR LA CONSULTA PARA ACTUALIZAR LA TESIS
        $sql_update = "UPDATE Tesis SET Titulo = ?, Estado = ?, Resumen = ?, Fecha_publicacion = ?, Carrera_ID = ? WHERE ID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssii", $titulo, $estado, $resumen, $fecha_publicacion, $carrera_id, $id);

        // ✅ EJECUTAR LA ACTUALIZACIÓN
        if ($stmt_update->execute()) {
            // ✅ REDIRIGIR AL LISTADO CON MENSAJE DE ÉXITO
            echo "<script>alert('Plan de negocio actualizado correctamente.'); window.location.href='gestionar_tesis.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error al actualizar el plan de negocio: " . $conn->error . "');</script>";
        }
    }
} else {
    die("ID de plan de negocio no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Plan de Negocios</title>
    <!-- Enlace a Bootstrap para diseño responsivo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
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
        .current-file {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #6a82fb;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- ✅ INFORMACIÓN DEL USUARIO -->
    <div class="user-info">
        <h4 class="mb-2">
            <i class="fas fa-edit"></i> Modificar Plan de Negocio
            <?php if ($rol === 'owner'): ?>
                <span class="owner-badge ms-2">OWNER</span>
            <?php else: ?>
                <span class="admin-badge ms-2">ADMINISTRADOR</span>
            <?php endif; ?>
        </h4>
        <p class="mb-0">Usuario: <strong><?= htmlspecialchars($usuarioData['nombre'] . ' ' . $usuarioData['apellido']) ?></strong> | Editando: <strong><?= htmlspecialchars($tesis['Titulo']) ?></strong></p>
    </div>

    <h2 class="mb-4">Modificar Plan de Negocio</h2>

    <!-- Botón para volver a la gestión de tesis -->
    <div class="mb-4">
        <a href="gestionar_tesis.php" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Volver a Gestionar Planes
        </a>
    </div>

    <!-- ✅ INFORMACIÓN DEL ARCHIVO ACTUAL -->
    <?php if (!empty($tesis['Archivo_pdf'])): ?>
    <div class="current-file mb-4">
        <h5><i class="fas fa-file-pdf"></i> Archivo Actual</h5>
        <p class="mb-1"><strong>Archivo PDF:</strong> <?= htmlspecialchars($tesis['Archivo_pdf']) ?></p>
        <a href="../Archivos/<?= htmlspecialchars($tesis['Archivo_pdf']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-eye"></i> Ver Archivo Actual
        </a>
        <small class="text-muted d-block mt-1">Nota: Para cambiar el archivo PDF, debe eliminar y volver a crear el plan.</small>
    </div>
    <?php endif; ?>

    <!-- Formulario para editar los campos de la tesis -->
    <form action="modificar_tesis.php?id=<?= $tesis['ID'] ?>" method="POST">
        <!-- Campo para el título -->
        <div class="mb-3">
            <label for="titulo" class="form-label">
                <i class="fas fa-heading"></i> Título del Plan
            </label>
            <input type="text" class="form-control" id="titulo" name="titulo" 
                   value="<?= htmlspecialchars($tesis['Titulo']) ?>" required
                   placeholder="Ingrese el título del plan de negocio">
        </div>

        <!-- Selector de estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">
                <i class="fas fa-chart-line"></i> Estado
            </label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="En proceso" <?= $tesis['Estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                <option value="Finalizada" <?= $tesis['Estado'] == 'Finalizada' ? 'selected' : '' ?>>Finalizada</option>
                <option value="Aprobada" <?= $tesis['Estado'] == 'Aprobada' ? 'selected' : '' ?>>Aprobada</option>
                <option value="En revisión" <?= $tesis['Estado'] == 'En revisión' ? 'selected' : '' ?>>En revisión</option>
            </select>
        </div>

        <!-- Campo para el resumen -->
        <div class="mb-3">
            <label for="resumen" class="form-label">
                <i class="fas fa-file-alt"></i> Resumen Ejecutivo
            </label>
            <textarea class="form-control" id="resumen" name="resumen" rows="5"
                      placeholder="Describa brevemente el plan de negocio..."><?= htmlspecialchars($tesis['Resumen']) ?></textarea>
        </div>

        <!-- Campo para el año de publicación -->
        <div class="mb-3">
            <label for="fecha_publicacion" class="form-label">
                <i class="fas fa-calendar-alt"></i> Año de Publicación
            </label>
            <input type="number" class="form-control" id="fecha_publicacion" name="fecha_publicacion" 
                   value="<?= $tesis['Fecha_publicacion'] ?>" min="2000" max="<?= date('Y') ?>" required>
        </div>

        <!-- Selector de carrera -->
        <div class="mb-3">
            <label for="carrera_id" class="form-label">
                <i class="fas fa-graduation-cap"></i> Carrera
            </label>
            <select class="form-control" id="carrera_id" name="carrera_id" required>
                <?php
                // Consultar todas las carreras disponibles para mostrarlas en el selector
                $sql_carreras = "SELECT * FROM Carrera ORDER BY Nombre";
                $result_carreras = $conn->query($sql_carreras);
                while ($row_carrera = $result_carreras->fetch_assoc()) {
                    $selected = ($row_carrera['ID'] == $tesis['Carrera_ID']) ? 'selected' : '';
                    echo "<option value='" . $row_carrera['ID'] . "' $selected>" . htmlspecialchars($row_carrera['Nombre']) . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Información de auditoría -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Información del Plan
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>ID:</strong> <?= $tesis['ID'] ?></p>
                <p class="mb-1"><strong>Autor:</strong> <?= htmlspecialchars($tesis['Autor'] ?? 'No especificado') ?></p>
                <p class="mb-0"><strong>Última modificación:</strong> <?= date('d/m/Y H:i:s') ?></p>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="gestionar_tesis.php" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <a href="eliminar_tesis.php?id=<?= $tesis['ID'] ?>" class="btn btn-danger btn-lg" 
               onclick="return confirm('¿Está seguro de eliminar este plan de negocio? Esta acción no se puede deshacer.');">
                <i class="fas fa-trash"></i> Eliminar
            </a>
        </div>
    </form>
</div>

<!-- Scripts de Bootstrap para la funcionalidad de componentes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>