<?php
// Mostrar todos los errores de PHP para facilitar la depuración durante el desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// ✅ VALIDACIÓN DE ACCESO: Solo 'Administrador' y 'Owner' pueden ingresar tesis
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
include('../Conection/conexion.php');

// ✅ CREAR CONEXIÓN A LA BASE DE DATOS
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensajeError = "";  // Variable para almacenar mensajes de error

// Obtener todas las carreras disponibles para el campo select
$queryCarreras = "SELECT ID, Nombre FROM Carrera";
$resultCarreras = $conn->query($queryCarreras);

/*---------------------------------------------------------------
| Procesamiento del formulario cuando el usuario envía datos POST
----------------------------------------------------------------*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $estado = $_POST['estado'];
    $resumen = $_POST['resumen'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $carrera_id = $_POST['carrera_id'];
    $palabras_clave = explode(",", $_POST['palabras_clave']); // Convertir la lista de palabras clave en array
    $archivo_pdf = "";

    /*----------------------------------------------------------
    | Subida del archivo PDF
    ----------------------------------------------------------*/
    if (isset($_FILES["archivo_pdf"]) && $_FILES["archivo_pdf"]["error"] == 0) {
        $archivo_pdf = basename($_FILES["archivo_pdf"]["name"]);
        $ruta_archivo = "../Archivos/" . $archivo_pdf;
        
        // ✅ VERIFICAR QUE SEA UN ARCHIVO PDF
        $extension = strtolower(pathinfo($archivo_pdf, PATHINFO_EXTENSION));
        if ($extension !== 'pdf') {
            echo "<script>alert('Solo se permiten archivos PDF.'); window.history.back();</script>";
            exit;
        }
        
        move_uploaded_file($_FILES["archivo_pdf"]["tmp_name"], $ruta_archivo);
    } else {
        echo "<script>alert('Error al subir el archivo PDF.'); window.history.back();</script>";
        exit;
    }

    /*----------------------------------------------------------
    | Si el usuario seleccionó "otra" como carrera y escribió una nueva
    ----------------------------------------------------------*/
    if ($carrera_id === "otra" && !empty($_POST['nueva_carrera'])) {
        $nueva_carrera = trim($_POST['nueva_carrera']);

        // Inserta la nueva carrera en la tabla Carrera
        $sqlNuevaCarrera = "INSERT INTO Carrera (Nombre) VALUES (?)";
        $stmtNuevaCarrera = $conn->prepare($sqlNuevaCarrera);
        $stmtNuevaCarrera->bind_param("s", $nueva_carrera);

        if ($stmtNuevaCarrera->execute()) {
            // Actualiza el ID de carrera con el ID recién insertado
            $carrera_id = $conn->insert_id;
        } else {
            die("Error al insertar nueva carrera: " . $stmtNuevaCarrera->error);
        }

        $stmtNuevaCarrera->close();
    }

    /*----------------------------------------------------------
    | Inserción de la tesis en la tabla Tesis
    ----------------------------------------------------------*/
    $sql = "INSERT INTO Tesis (Titulo, Autor, Estado, Resumen, Fecha_publicacion, Archivo_pdf, Carrera_ID)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $titulo, $autor, $estado, $resumen, $fecha_publicacion, $archivo_pdf, $carrera_id);

    if ($stmt->execute()) {
        $tesis_id = $conn->insert_id;  // Recuperar el ID de la tesis recién insertada

        /*----------------------------------------------------------
        | Inserción de palabras clave y su relación con la tesis
        ----------------------------------------------------------*/
        foreach ($palabras_clave as $palabra) {
            $palabra = trim($palabra);
            if (!empty($palabra)) {
                // Verificar si la palabra clave ya existe
                $sql_check = "SELECT ID FROM PalabraClave WHERE Palabra = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("s", $palabra);
                $stmt_check->execute();
                $res_check = $stmt_check->get_result();

                if ($res_check->num_rows > 0) {
                    // Si ya existe, obtener su ID
                    $row = $res_check->fetch_assoc();
                    $palabra_id = $row['ID'];
                } else {
                    // Si no existe, insertarla
                    $sql_insert = "INSERT INTO PalabraClave (Palabra) VALUES (?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("s", $palabra);
                    $stmt_insert->execute();
                    $palabra_id = $conn->insert_id;
                }

                // Insertar la relación entre la tesis y la palabra clave
                $sql_rel = "INSERT INTO TesisPalabraClave (Tesis_ID, PalabraClave_ID) VALUES (?, ?)";
                $stmt_rel = $conn->prepare($sql_rel);
                $stmt_rel->bind_param("ii", $tesis_id, $palabra_id);
                $stmt_rel->execute();
            }
        }

        // Mensaje de éxito y redirección
        echo "<script>alert('Plan de negocio registrado correctamente.'); window.location.href='gestionar_tesis.php';</script>";
    } else {
        echo "Error al registrar el plan de negocio: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Plan de Negocios</title>
    <!-- Incluimos Bootstrap para estilos -->
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
    </style>
</head>

<!-- Script para mostrar el campo de nueva carrera solo si el usuario selecciona "otra" -->
<script>
function toggleNuevaCarrera(selectElement) {
    const nuevaCarreraDiv = document.getElementById("nueva_carrera_div");
    if (selectElement.value === "otra") {
        nuevaCarreraDiv.style.display = "block";
        document.getElementById("nueva_carrera").required = true;
    } else {
        nuevaCarreraDiv.style.display = "none";
        document.getElementById("nueva_carrera").required = false;
    }
}
</script>

<body>

<div class="container mt-5">
    <!-- ✅ INFORMACIÓN DEL USUARIO -->
    <div class="user-info">
        <h4 class="mb-2">
            <i class="fas fa-plus-circle"></i> Ingresar Nuevo Plan de Negocio
            <?php if ($rol === 'owner'): ?>
                <span class="owner-badge ms-2">OWNER</span>
            <?php else: ?>
                <span class="admin-badge ms-2">ADMINISTRADOR</span>
            <?php endif; ?>
        </h4>
        <p class="mb-0">Usuario: <strong><?= htmlspecialchars($usuarioData['nombre'] . ' ' . $usuarioData['apellido']) ?></strong></p>
    </div>

    <h2 class="mb-4">Ingresar Plan de Negocio</h2>

    <!-- Mostrar mensaje de error si existe -->
    <?php if (!empty($mensajeError)): ?>
        <div class="alert alert-info"><?= $mensajeError ?></div>
    <?php endif; ?>

    <!-- Botón para regresar a la gestión de tesis -->
    <div class="mb-3 mt-3">
        <a href="gestionar_tesis.php" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Volver a Gestionar Planes
        </a>
    </div>

    <!-- Formulario para ingreso de nueva tesis -->
    <form method="POST" enctype="multipart/form-data">
        <!-- Título -->
        <div class="mb-3">
            <label for="titulo" class="form-label">
                <i class="fas fa-heading"></i> Título del Plan
            </label>
            <input type="text" class="form-control" id="titulo" name="titulo" required 
                   placeholder="Ingrese el título del plan de negocio">
        </div>

        <!-- Autor -->
        <div class="mb-3">
            <label for="autor" class="form-label">
                <i class="fas fa-user"></i> Autor(es)
            </label>
            <input type="text" class="form-control" id="autor" name="autor" required 
                   placeholder="Nombre del autor o autores">
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="estado" class="form-label">
                <i class="fas fa-chart-line"></i> Estado del Plan
            </label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="">-- Seleccione el estado --</option>
                <option value="En proceso">En proceso</option>
                <option value="Finalizada">Finalizada</option>
                <option value="Aprobada">Aprobada</option>
                <option value="En revisión">En revisión</option>
            </select>
        </div>

        <!-- Resumen -->
        <div class="mb-3">
            <label for="resumen" class="form-label">
                <i class="fas fa-file-alt"></i> Resumen Ejecutivo
            </label>
            <textarea class="form-control" id="resumen" name="resumen" rows="4" required 
                      placeholder="Describa brevemente el plan de negocio..."></textarea>
        </div>

        <!-- Año de publicación -->
        <div class="mb-3">
            <label for="fecha_publicacion" class="form-label">
                <i class="fas fa-calendar-alt"></i> Año de Publicación
            </label>
            <input type="number" class="form-control" id="fecha_publicacion" name="fecha_publicacion" 
                   min="2000" max="<?= date('Y') ?>" value="<?= date('Y') ?>" required>
        </div>

        <!-- Archivo PDF -->
        <div class="mb-3">
            <label for="archivo_pdf" class="form-label">
                <i class="fas fa-file-pdf"></i> Archivo PDF
            </label>
            <input type="file" class="form-control" id="archivo_pdf" name="archivo_pdf" 
                   accept=".pdf" required>
            <div class="form-text">Solo se permiten archivos PDF</div>
        </div>

        <!-- Carrera -->
        <div class="mb-3">
            <label for="carrera_id" class="form-label">
                <i class="fas fa-graduation-cap"></i> Carrera
            </label>
            <select class="form-control" id="carrera_id" name="carrera_id" required onchange="toggleNuevaCarrera(this)">
                <option value="">-- Selecciona una carrera --</option>
                <?php 
                // Reiniciar el puntero del resultado para volver a iterar
                $resultCarreras->data_seek(0);
                while ($row = $resultCarreras->fetch_assoc()): ?>
                    <option value="<?= $row['ID'] ?>"><?= htmlspecialchars($row['Nombre']) ?></option>
                <?php endwhile; ?>
                <option value="otra">Otra (Agregar nueva carrera)</option>
            </select>
        </div>

        <!-- Campo para nueva carrera (solo visible si elige "otra") -->
        <div class="mb-3" id="nueva_carrera_div" style="display: none;">
            <label for="nueva_carrera" class="form-label">
                <i class="fas fa-plus"></i> Nombre de la nueva carrera
            </label>
            <input type="text" class="form-control" id="nueva_carrera" name="nueva_carrera" 
                   placeholder="Ingrese el nombre de la nueva carrera">
        </div>

        <!-- Palabras clave -->
        <div class="mb-3">
            <label for="palabras_clave" class="form-label">
                <i class="fas fa-tags"></i> Palabras Clave
            </label>
            <input type="text" class="form-control" id="palabras_clave" name="palabras_clave" required 
                   placeholder="Ej: marketing, finanzas, emprendimiento, innovación">
            <div class="form-text">Separe las palabras clave con comas</div>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save"></i> Registrar Plan de Negocio
        </button>
        
        <a href="gestionar_tesis.php" class="btn btn-secondary btn-lg">
            <i class="fas fa-times"></i> Cancelar
        </a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>