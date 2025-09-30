<?php
// Habilitar la visualización de errores durante el desarrollo (esto es útil para detectar problemas)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión para poder obtener el rol del usuario y controlar acceso o mostrar menús según el tipo de usuario
session_start();

// Incluir el archivo de conexión a la base de datos
include ('../Conection/conexion.php');

// ------------------------- //
// 1. Definir el ordenamiento //
// ------------------------- //
$order_by = "Fecha_publicacion DESC";  // Orden por defecto: más recientes primero

// Si el usuario selecciona un orden distinto (pasado por URL con GET)
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

// ------------------------- //
// 2. Conexión a la base de datos //
// ------------------------- //
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// ------------------------- //
// 3. Filtro por carrera //
// ------------------------- //
// Si se ha pasado por GET un ID de carrera, se toma ese valor, si no, se asume "todas"
$carrera_filtro = isset($_GET['carrera']) ? intval($_GET['carrera']) : 0;

// ------------------------- //
// 4. Construir la consulta principal //
// ------------------------- //
$sql = "SELECT t.*, c.Nombre AS NombreCarrera
        FROM Tesis t
        JOIN Carrera c ON t.Carrera_ID = c.ID";

// Si el usuario seleccionó una carrera específica, se añade condición WHERE
if ($carrera_filtro > 0) {
    $sql .= " WHERE t.Carrera_ID = $carrera_filtro";
}

// ------------------------- //
// 5. Agregar el ordenamiento //
// ------------------------- //
$sql .= " ORDER BY $order_by";

// ------------------------- //
// 6. Ejecutar la consulta de tesis //
// ------------------------- //
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

// ------------------------- //
// 7. Obtener lista de carreras para el filtro //
// ------------------------- //
$sql_carreras = "SELECT ID, Nombre FROM Carrera ORDER BY Nombre";
$result_carreras = $conn->query($sql_carreras);

// ------------------------- //
// 8. Obtener rol del usuario actual //
// ------------------------- //
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Repositorio de Planes de Negocios</title>

    <!-- Ícono de la pestaña -->
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQradELIH2EABbwe93oJ0s--V91loD8gTe0jg&s" type="image/png" />

    <!-- Configuración responsive para móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap para diseño responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color:  #0056b3;
            --secondary-color: #2c3e50;
            --accent-color: #f7faf8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #6a1b9a;
        }
        
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 80px;
            color: #333;
            line-height: 1.6;
        }
        
        /* Navbar */
        .navbar {
            background-color: var(--secondary-color) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 8px 15px;
            margin: 0 5px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-link.active {
            color: var(--accent-color) !important;
        }
        
        /* Main Container */
        .main-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 40px;
        }
        
        /* Header */
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .page-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        /* Filter Section */
        .filter-section {
            background-color: var(--light-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        
        .filter-label {
            font-weight: 600;
            margin-right: 10px;
            color: var(--secondary-color);
        }
        
        .form-select {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-refresh {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-refresh:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        /* Thesis Card */
        .thesis-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .thesis-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .card-body {
            padding: 25px;
        }
        
        .card-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .meta-item i {
            margin-right: 5px;
            color: var(--primary-color);
        }
        
        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn-details {
            background-color: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .btn-details:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-pdf {
            background-color: var(--success-color);
            border-color: var(--success-color);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-pdf:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        /* Collapse Content */
        .collapse-content {
            padding: 20px;
            background-color: var(--light-color);
            border-top: 1px solid #eee;
        }
        
        .section-title {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        
        .keyword {
            background-color: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        /* Footer */
        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 25px 0;
            text-align: center;
            margin-top: 50px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .card-actions {
                flex-direction: column;
            }
            
            .filter-section {
                padding: 15px;
            }
        }
        
        .card-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }

        .career-badge {
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: bold;
            border-radius: 20px;
            color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }


        /* Colores */
        .badge-0 { background-color: #e74c3c; }
        .badge-1 { background-color: #2980b9; }
        .badge-2 { background-color: #27ae60; }
        .badge-3 { background-color: #8e44ad; }
        .badge-4 { background-color: #d35400; }
        .badge-5 { background-color: #16a085; }
        .badge-6 { background-color: #2c3e50; }
        .badge-7 { background-color: #f39c12; }
        .badge-8 { background-color: #c0392b; }
        .badge-9 { background-color: #34495e; }
    </style>
</head>
<body>

<!-- NAVBAR SUPERIOR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-book-open"></i> Repositorio de Planes
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <!-- Opciones del menú -->
                <li class="nav-item"><a href="../index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="lista_tesis.php" class="nav-link active">Plan de Negocios</a></li>

                <!-- Menú visible solo para administradores -->
                <?php if ($rol == 'Administrador' || $rol == 'Owner'): ?>
                    <li class="nav-item"><a href="../Admin/gestionar_tesis.php" class="nav-link">Gestionar Planes</a></li>
                <?php endif; ?>

                <!-- Menú exclusivo del Owner -->
                <?php if ($rol == 'Owner'): ?>
                    <li class="nav-item"><a href="../Admin/gestionar_administradores.php" class="nav-link">Administradores</a></li>
                <?php endif; ?>

                <!-- Cierre de sesión -->
                <li class="nav-item"><a href="../Accesos/logout.php" class="nav-link">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<div class="container main-container">

    <!-- Título de página -->
    <div class="page-header">
        <h1 class="page-title">Lista de Planes de Negocios</h1>
    </div>
    
    <!-- Filtro y ordenamiento -->
    <div class="filter-section">
        <form class="row g-3 align-items-center" method="GET">
            <!-- Selector de orden -->
            <div class="col-md-4">
                <label for="orden" class="filter-label col-form-label">Ordenar por:</label>
                <select name="orden" id="orden" class="form-select" onchange="this.form.submit()">
                    <option value="fecha_desc" <?= ($_GET['orden'] ?? '') === 'fecha_desc' ? 'selected' : '' ?>>Fecha (más recientes)</option>
                    <option value="fecha_asc" <?= ($_GET['orden'] ?? '') === 'fecha_asc' ? 'selected' : '' ?>>Fecha (más antiguas)</option>
                    <option value="titulo_asc" <?= ($_GET['orden'] ?? '') === 'titulo_asc' ? 'selected' : '' ?>>Título (A-Z)</option>
                    <option value="titulo_desc" <?= ($_GET['orden'] ?? '') === 'titulo_desc' ? 'selected' : '' ?>>Título (Z-A)</option>
                    <option value="visualizaciones_asc" <?= ($_GET['orden'] ?? '') === 'visualizaciones_asc' ? 'selected' : '' ?>>Visualizaciones (menor primero)</option>
                    <option value="visualizaciones_desc" <?= ($_GET['orden'] ?? '') === 'visualizaciones_desc' ? 'selected' : '' ?>>Visualizaciones (mayor primero)</option>
                </select>
            </div>

            <!-- Selector de carrera -->
            <div class="col-md-4">
                <label for="carrera" class="filter-label col-form-label">Filtrar por carrera:</label>
                <select name="carrera" id="carrera" class="form-select" onchange="this.form.submit()">
                    <option value="0">Todas</option>
                    <?php while ($row_carrera = $result_carreras->fetch_assoc()): ?>
                        <option value="<?= $row_carrera['ID'] ?>" <?= ($carrera_filtro == $row_carrera['ID']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row_carrera['Nombre']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Botón aplicar -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-refresh w-100">
                    <i class="fas fa-filter"></i> Aplicar
                </button>
            </div>
        </form>
    </div>
    
    <!-- LISTA DE TESIS -->
    <div class="thesis-list">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                // Obtener nombre de la carrera
                $carrera = $row['NombreCarrera'];

                // Determinar color de la badge según el ID de la carrera
                $color_index = $row['Carrera_ID'] % 10;

                // Consultar las palabras clave asociadas a la tesis
                $tesis_id = $row['ID'];
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
                ?>
                <!-- Tarjeta de tesis -->
                <div class="card thesis-card">
                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars($row['Titulo']) ?></h3>
                        
                        <!-- Meta datos de la tesis -->
                        <div class="card-meta">
                            <span class="meta-item">
                                <i class="far fa-calendar-alt"></i>
                                <?= htmlspecialchars($row['Fecha_publicacion']) ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-chart-line"></i>
                                <?= htmlspecialchars($row['Visualizaciones']) ?> visualizaciones
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-info-circle"></i>
                                <?= htmlspecialchars($row['Estado']) ?>
                            </span>
                        </div>
                        
                        <!-- Acciones: Detalles y Ver PDF -->
                        <div class="card-bottom d-flex justify-content-between align-items-center mt-3">
                            <div class="card-actions">
                                <button class="btn btn-details" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#detalles<?= $tesis_id ?>" aria-expanded="false">
                                    <i class="fas fa-chevron-down"></i> Detalles
                                </button>
                                <a href="../Conection/ver_pdf.php?id=<?= $tesis_id ?>" target="_blank" class="btn btn-pdf">
                                    <i class="fas fa-file-pdf"></i> Ver PDF
                                </a>
                            </div>
                            <!-- Badge de carrera -->
                            <div class="career-badge badge-<?= $color_index ?>">
                                <?= htmlspecialchars($carrera) ?>
                            </div>
                        </div>

                        <!-- Sección desplegable con el resumen y palabras clave -->
                        <div class="collapse" id="detalles<?= $tesis_id ?>">
                            <div class="collapse-content mt-3">
                                <h5 class="section-title">Resumen</h5>
                                <p><?= nl2br(htmlspecialchars($row['Resumen'])) ?></p>
                                
                                <h5 class="section-title">Palabras Clave</h5>
                                <div class="keywords">
                                    <?php foreach ($palabras_clave as $palabra): ?>
                                        <span class="keyword"><?= htmlspecialchars($palabra) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Mensaje si no hay tesis -->
            <div class="alert alert-info text-center">
                No hay planes de negocio registrados actualmente.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> Repositorio de Planes de Negocio. Todos los derechos reservados.</p>
    </div>
</footer>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Cerrar conexión a la base de datos
$conn->close();
?>
