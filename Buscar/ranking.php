<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include ('../Conection/conexion.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM Tesis ORDER BY Visualizaciones DESC LIMIT 10";
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Planes de Negocios - Top 10 Visualizaciones</title>
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQradELIH2EABbwe93oJ0s--V91loD8gTe0jg&s" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --accent-color: #ff9800;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --overlay-color: rgba(44, 62, 80, 0.85);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            padding-top: 80px;
        }
        
        /* Navbar - Coherente con index.php */
        .navbar {
            background: var(--dark-color) !important;
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 15px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-nav .nav-link.active {
            background: var(--secondary-color);
            color: white !important;
        }
        
        /* Contenedor principal */
        .main-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        /* Título */
        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        
        /* Items del ranking */
        .ranking-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 5px solid transparent;
        }
        
        .ranking-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Números del ranking */
        .ranking-number {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            margin-right: 25px;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Colores para los primeros puestos */
        .ranking-number.gold {
            background: linear-gradient(135deg, #FFD700, #D4AF37);
        }
        
        .ranking-number.silver {
            background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
        }
        
        .ranking-number.bronze {
            background: linear-gradient(135deg, #CD7F32, #B87333);
        }
        
        .ranking-number.other {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
        
        /* Contenido del item */
        .ranking-content {
            flex-grow: 1;
        }
        
        .ranking-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            font-size: 1.2rem;
        }
        
        .ranking-meta {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .ranking-meta span {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }
        
        .ranking-meta i {
            margin-right: 5px;
            color: var(--secondary-color);
        }
        
        .ranking-views {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        /* Botones */
        .btn-ranking {
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .btn-details {
            background: white;
            border: 1px solid var(--secondary-color);
            color: var(--secondary-color);
        }
        
        .btn-details:hover {
            background: var(--secondary-color);
            color: white;
        }
        
        .btn-pdf {
            background: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-pdf:hover {
            background: #5e1491;
            color: white;
        }
        
        /* Detalles colapsables */
        .ranking-details {
            margin-top: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 3px solid var(--accent-color);
        }
        
        .ranking-details p {
            margin-bottom: 10px;
        }
        
        .keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        
        .keyword {
            background: rgba(106, 27, 154, 0.1);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .ranking-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .ranking-number {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .ranking-meta span {
                margin-right: 10px;
                margin-bottom: 5px;
            }
        }
        
        /* Mensaje cuando no hay resultados */
        .no-results {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1rem;
        }
        
        .no-results i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <!-- Navbar - Coherente con index.php -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-trophy"></i> Ranking Planes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lista_tesis.php">Planes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="ranking.php">Ranking</a>
                    </li>
                    <?php if ($rol == 'Administrador' || $rol == 'Owner'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin/gestionar_tesis.php">Gestionar Planes</a>
                    </li>
                    <?php endif; ?>
                    <?php if ($rol == 'Owner'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin/gestionar_administradores.php">Administradores</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Accesos/logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <h1 class="page-title">Top 10 Planes Más Visualizados</h1>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <?php 
            $posicion = 1; 
            while ($row = $result->fetch_assoc()):
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
                
                // Clase para el número según posición
                $clase_numero = 'other';
                if ($posicion === 1) {
                    $clase_numero = 'gold';
                } else if ($posicion === 2) {
                    $clase_numero = 'silver';
                } else if ($posicion === 3) {
                    $clase_numero = 'bronze';
                }
            ?>
                <div class="ranking-item">
                    <div class="ranking-number <?= $clase_numero ?>"><?= $posicion ?></div>
                    <div class="ranking-content">
                        <h3 class="ranking-title"><?= htmlspecialchars($row['Titulo']) ?></h3>
                        <div class="ranking-meta">
                            <span><i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($row['Fecha_publicacion']) ?></span>
                            <span><i class="fas fa-check-circle"></i> <?= htmlspecialchars($row['Estado']) ?></span>
                            <span class="ranking-views"><i class="fas fa-eye"></i> <?= htmlspecialchars($row['Visualizaciones']) ?> visualizaciones</span>
                        </div>
                        
                        <div class="ranking-actions">
                            <button class="btn btn-ranking btn-details" type="button" data-bs-toggle="collapse" data-bs-target="#detalles<?= $row['ID'] ?>">
                                <i class="fas fa-info-circle"></i> Detalles
                            </button>
                            <a href="../Conection/ver_pdf.php?id=<?= $row['ID'] ?>" target="_blank" class="btn btn-ranking btn-pdf">
                                <i class="fas fa-file-pdf"></i> Ver PDF
                            </a>
                        </div>
                        
                        <div class="collapse ranking-details" id="detalles<?= $row['ID'] ?>">
                            <p><strong>Resumen:</strong> <?= nl2br(htmlspecialchars($row['Resumen'])) ?></p>
                            <?php if (!empty($palabras_clave)): ?>
                                <div>
                                    <strong>Palabras clave:</strong>
                                    <div class="keywords">
                                        <?php foreach ($palabras_clave as $palabra): ?>
                                            <span class="keyword"><?= htmlspecialchars($palabra) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php 
                $posicion++;
            endwhile; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-book-open"></i>
                <p>No hay planes de negocio registrados todavía.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>