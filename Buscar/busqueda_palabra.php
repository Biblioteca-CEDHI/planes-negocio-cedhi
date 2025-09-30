<?php
// Activar la visualización de errores durante el desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión
session_start();
include('../Conection/conexion.php');

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener parámetros de búsqueda enviados por GET
$searchparam = isset($_GET['searchparam']) ? trim($_GET['searchparam']) : '';
$searchparam_sql = $conn->real_escape_string($searchparam);

// Obtener filtro de carrera (si se selecciona)
$carrera_id = isset($_GET['carrera_id']) ? intval($_GET['carrera_id']) : 0;

// Determinar ordenamiento predeterminado
$order_by = "Fecha_publicacion DESC";

// Cambiar orden según selección del usuario
if (isset($_GET['orden'])) {
    switch ($_GET['orden']) {
        case 'fecha_asc': $order_by = "Fecha_publicacion ASC"; break;
        case 'fecha_desc': $order_by = "Fecha_publicacion DESC"; break;
        case 'titulo_asc': $order_by = "Titulo ASC"; break;
        case 'titulo_desc': $order_by = "Titulo DESC"; break;
        case 'visualizaciones_asc': $order_by = "Visualizaciones ASC"; break;
        case 'visualizaciones_desc': $order_by = "Visualizaciones DESC"; break;
    }
}

// Función para normalizar texto: quitar mayúsculas, tildes y caracteres especiales
function normalizarTexto($texto) {
    $texto = mb_strtolower($texto, 'UTF-8');
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
    return preg_replace('/[^a-z0-9\s]/i', '', $texto);
}

// Lista de stopwords que no queremos incluir como términos de búsqueda
$stopwords = ['el', 'la', 'los', 'las', 'de', 'del', 'y', 'en', 'un', 'una', 'que', 'con', 'para', 'por', 'al', 'a'];

// Normalizamos la búsqueda y separamos en palabras clave (tokens)
$normalizado = normalizarTexto($searchparam_sql);
$tokens = array_filter(explode(' ', $normalizado), function ($t) use ($stopwords) {
    return strlen($t) > 2 && !in_array($t, $stopwords);
});

// Construcción de cláusulas WHERE dinámicas para la búsqueda
$where_clauses = [];

foreach ($tokens as $word) {
    $escaped_word = $conn->real_escape_string($word);

    // Si el token es numérico, también lo buscamos en Fecha de Publicación
    if (is_numeric($word)) {
        $where_clauses[] = "(
            LOWER(Titulo) LIKE '%$escaped_word%' OR 
            LOWER(Fecha_Publicacion) LIKE '%$escaped_word%')";
    } else {
        $where_clauses[] = "(
            LOWER(Titulo) LIKE '%$escaped_word%' OR 
            LOWER(Estado) LIKE '%$escaped_word%' OR 
            LOWER(Resumen) LIKE '%$escaped_word%' OR 
            LOWER(Fecha_Publicacion) LIKE '%$escaped_word%' OR 
            LOWER(Autor) LIKE '%$escaped_word%')";
    }
}

// Agregar filtro por carrera si corresponde
if ($carrera_id > 0) {
    $where_clauses[] = "Tesis.Carrera_ID = $carrera_id";
}

// Armado final de la consulta SQL
$sql = "SELECT Tesis.*, Carrera.Nombre AS Carrera_Nombre 
        FROM Tesis 
        LEFT JOIN Carrera ON Tesis.Carrera_ID = Carrera.ID";

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY $order_by";

// Ejecutar consulta
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Si hubo resultados, registramos la palabra buscada en la tabla de sugerencias
if (!empty($searchparam) && $result->num_rows > 0) {
    $palabra = strtolower($searchparam_sql);
    $checkSql = "SELECT contador FROM PalabrasBuscadas WHERE palabra = '$palabra'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        $conn->query("UPDATE PalabrasBuscadas SET contador = contador + 1 WHERE palabra = '$palabra'");
    } else {
        $conn->query("INSERT INTO PalabrasBuscadas (palabra, contador) VALUES ('$palabra', 1)");
    }
}

// Capturar rol de usuario para personalizar menú
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
?>

<!-- HTML para mostrar resultados -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Diseño visual: tarjetas, colores por carrera y botones */
        .card-bottom { display: flex; justify-content: space-between; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px; }
        .card-actions { display: flex; gap: 10px; }
        .career-badge { padding: 6px 12px; font-size: 0.85rem; font-weight: bold; border-radius: 20px; color: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); }
        .badge-0 { background-color: #e74c3c; } .badge-1 { background-color: #2980b9; } .badge-2 { background-color: #27ae60; }
        .badge-3 { background-color: #8e44ad; } .badge-4 { background-color: #d35400; } .badge-5 { background-color: #16a085; }
        .badge-6 { background-color: #2c3e50; } .badge-7 { background-color: #f39c12; } .badge-8 { background-color: #c0392b; }
        .badge-9 { background-color: #34495e; }
    </style>
</head>
<body>

<!-- Menú de navegación -->
<nav class="navbar">
    <div><strong>Repositorio de Planes de Negocios</strong></div>
    <div>
        <a href="../index.php">Inicio</a>
        <a href="lista_tesis.php">Planes</a>
        <?php if ($rol == 'Administrador' || $rol == 'Owner'): ?>
            <a href="../Admin/gestionar_tesis.php">Gestionar Planes</a>
        <?php endif; ?>
        <?php if ($rol == 'Owner'): ?>
            <a href="../Admin/gestionar_administradores.php">Gestionar Administradores</a>
        <?php endif; ?>
        <a href="../Accesos/logout.php">Cerrar Sesión</a>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container table-container">
    <h2 class="text-center">Resultados de búsqueda para: "<?= htmlspecialchars($searchparam) ?>"</h2>

    <!-- Filtro por carrera si corresponde -->
    <?php if ($carrera_id > 0):
        $nombre_carrera = 'Carrera seleccionada';
        $query_nombre = $conn->query("SELECT Nombre FROM Carrera WHERE ID = $carrera_id");
        if ($query_nombre && $query_nombre->num_rows > 0) {
            $nombre_carrera = $query_nombre->fetch_assoc()['Nombre'];
        }
    ?>
        <p class="text-center"><strong>Filtrado por carrera:</strong> <?= htmlspecialchars($nombre_carrera) ?></p>
    <?php endif; ?>

    <!-- Filtro de carrera y ordenamiento -->
    <form class="form-inline mb-4" method="GET">
        <input type="hidden" name="searchparam" value="<?= htmlspecialchars($searchparam) ?>">

        <!-- Filtro carrera -->
        <label>Carrera:</label>
        <select name="carrera_id" class="form-control" onchange="this.form.submit()">
            <option value="0">Todas las carreras</option>
            <?php
            $query_carreras = $conn->query("SELECT ID, Nombre FROM Carrera ORDER BY Nombre ASC");
            while ($row_carrera = $query_carreras->fetch_assoc()) {
                $selected = ($carrera_id == $row_carrera['ID']) ? 'selected' : '';
                echo "<option value='{$row_carrera['ID']}' $selected>" . htmlspecialchars($row_carrera['Nombre']) . "</option>";
            }
            ?>
        </select>

        <!-- Orden -->
        <label>Orden:</label>
        <select name="orden" class="form-control" onchange="this.form.submit()">
            <option value="fecha_desc" <?= (($_GET['orden'] ?? '') === 'fecha_desc') ? 'selected' : '' ?>>Más recientes</option>
            <option value="fecha_asc" <?= (($_GET['orden'] ?? '') === 'fecha_asc') ? 'selected' : '' ?>>Más antiguas</option>
            <option value="titulo_asc" <?= (($_GET['orden'] ?? '') === 'titulo_asc') ? 'selected' : '' ?>>Título A-Z</option>
            <option value="titulo_desc" <?= (($_GET['orden'] ?? '') === 'titulo_desc') ? 'selected' : '' ?>>Título Z-A</option>
            <option value="visualizaciones_asc" <?= (($_GET['orden'] ?? '') === 'visualizaciones_asc') ? 'selected' : '' ?>>Menos visualizaciones</option>
            <option value="visualizaciones_desc" <?= (($_GET['orden'] ?? '') === 'visualizaciones_desc') ? 'selected' : '' ?>>Más visualizaciones</option>
        </select>
    </form>

    <!-- Resultados -->
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="row">
        <?php while($row = $result->fetch_assoc()): ?>
            <?php
            $tesis_id = $row['ID'];
            $carrera_nombre = $row['Carrera_Nombre'] ?? 'Sin carrera';
            $color_index = $row['Carrera_ID'] % 10;

            // Obtener palabras clave de cada tesis
            $sql_palabras = "SELECT Palabra FROM PalabraClave
                            JOIN TesisPalabraClave ON PalabraClave.ID = TesisPalabraClave.PalabraClave_ID
                            WHERE TesisPalabraClave.Tesis_ID = ?";
            $stmt_palabras = $conn->prepare($sql_palabras);
            $stmt_palabras->bind_param("i", $tesis_id);
            $stmt_palabras->execute();
            $result_palabras = $stmt_palabras->get_result();

            $palabras_clave = [];
            while ($row_palabra = $result_palabras->fetch_assoc()) {
                $palabras_clave[] = $row_palabra['Palabra'];
            }
            $lista_palabras = implode(", ", $palabras_clave);
            ?>
            <!-- Tarjeta de resultado -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($row['Titulo']) ?></h5>
                        <p><strong>Fecha:</strong> <?= htmlspecialchars($row['Fecha_publicacion']) ?> |
                           <strong>Estado:</strong> <?= htmlspecialchars($row['Estado']) ?> |
                           <strong>Visualizaciones:</strong> <?= htmlspecialchars($row['Visualizaciones']) ?>
                        </p>
                        <div class="card-bottom">
                            <div class="card-actions">
                                <button class="btn btn-outline-secondary btn-sm" type="button" data-toggle="collapse" data-target="#detalles<?= $tesis_id ?>">Mostrar Detalles</button>
                                <a href="../Conection/ver_pdf.php?id=<?= $tesis_id ?>" target="_blank" class="btn btn-primary btn-sm">Ver PDF</a>
                            </div>
                            <div class="career-badge badge-<?= $color_index ?>">
                                <?= htmlspecialchars($carrera_nombre) ?>
                            </div>
                        </div>
                        <div class="collapse mt-3" id="detalles<?= $tesis_id ?>">
                            <p><strong>Resumen:</strong><br><?= nl2br(htmlspecialchars($row['Resumen'])) ?></p>
                            <p><strong>Palabras Clave:</strong> <?= htmlspecialchars($lista_palabras) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center mt-4">No se encontraron resultados para "<strong><?= htmlspecialchars($searchparam) ?></strong>".</p>
    <?php endif; ?>

    <!-- Sección de sugerencias -->
    <?php if (!empty($searchparam)): ?>
    <div class="mt-4">
        <h5>Otras personas también buscaron:</h5>
        <div>
            <?php
            $base = substr(strtolower($searchparam), 0, 3);
            $query_sugerencias = "SELECT palabra FROM PalabrasBuscadas 
                                  WHERE palabra LIKE '%$base%' AND palabra != '$searchparam_sql' 
                                  ORDER BY contador DESC LIMIT 10";
            $resultado_sugerencias = $conn->query($query_sugerencias);
            if ($resultado_sugerencias && $resultado_sugerencias->num_rows > 0):
                while ($row_sugerencia = $resultado_sugerencias->fetch_assoc()):
                    $sugerida = htmlspecialchars($row_sugerencia['palabra']);
                    echo "<a href='?searchparam=" . urlencode($sugerida) . "' class='badge badge-info m-1'>$sugerida</a>";
                endwhile;
            else:
                echo "<span class='text-muted'>No se encontraron sugerencias.</span>";
            endif;
            ?>
        </div>
    </div>
    <style>
        .badge-info { text-align: center; cursor: pointer; font-size: 1rem; }
    </style>
    <?php endif; ?>
</div>

<!-- Cerrar conexión -->
<?php $conn->close(); ?>

<!-- Scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




