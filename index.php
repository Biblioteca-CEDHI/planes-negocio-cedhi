<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ INCLUIR AUTENTICACIÓN CENTRAL
include_once "Accesos/auth_central.php";

// ✅ VERIFICAR AUTENTICACIÓN (pero no redirigir inmediatamente - es la página pública)
$estaAutenticado = validarAutenticacionCentral();
$usuarioData = $estaAutenticado ? obtenerUsuarioCentral() : null;
$rol = $estaAutenticado ? strtolower($usuarioData['rol']) : null;

// ✅ INICIAR SESIÓN PARA COMPATIBILIDAD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ ASIGNAR VARIABLES DE SESIÓN SI ESTÁ AUTENTICADO
if ($estaAutenticado) {
    $_SESSION['rol'] = $rol;
    $_SESSION['id'] = $usuarioData['id'];
    $_SESSION['email'] = $usuarioData['email'];
    $_SESSION['nombre'] = $usuarioData['nombre'];
    $_SESSION['apellido'] = $usuarioData['apellido'];
}

// El resto del código igual...
include_once('Conection/conexion.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$searchparam = isset($_GET['searchparam']) ? $_GET['searchparam'] : '';

// Consulta principal de tesis según búsqueda
$sql = "SELECT * FROM Tesis";
if ($searchparam != '') {
    $search = $conn->real_escape_string($searchparam);
    $sql .= " WHERE MATCH(titulo, autor, resumen) AGAINST('$search' IN NATURAL LANGUAGE MODE)";
}
$result = $conn->query($sql);

// Consulta para obtener las 10 palabras más buscadas (solo las que tienen resultados)
$sql_busquedas = "SELECT palabra, contador FROM PalabrasBuscadas ORDER BY contador DESC LIMIT 10";
$result_busquedas = $conn->query($sql_busquedas);
var_dump($_SESSION);
$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Repositorio de Planes de Negocios</title>
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQradELIH2EABbwe93oJ0s--V91loD8gTe0jg&s" type="image/png">
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
        
        body, html {
            margin: 0; 
            padding: 0; 
            width: 100%; 
            height: 100%; 
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        /* Navbar mejorado */
        .navbar {
            background: var(--dark-color) !important;
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
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
        
        /* Hero Section */
        .hero-section {
            position: relative;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--overlay-color);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .hero-logo {
            max-width: 400px;
            margin-bottom: 30px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 40px;
            font-weight: 300;
            opacity: 0.9;
        }
        
        /* Search Bar */
        .search-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .search-form {
            position: relative;
            width: 100%;
        }
        
        .search-input {
            width: 100%;
            padding: 18px 25px;
            font-size: 1.1rem;
            border: none;
            border-radius: 50px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }
        
        .search-button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 13px 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .search-button:hover {
            background: var(--primary-color);
        }
        
        /* Popular Searches */
        .popular-searches {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-top: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .popular-searches h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .popular-searches h3 i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .search-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        
        .search-tag {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .search-tag:hover {
            background: var(--accent-color);
            color: var(--dark-color);
            transform: translateY(-2px);
            cursor: pointer;
        }
        
        .search-tag .count {
            font-size: 0.8rem;
            margin-left: 5px;
            background: rgba(0, 0, 0, 0.2);
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        /* Carousel */
        .carousel {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        
        .carousel img.active {
            opacity: 1;
            z-index: 0;
        }
        
        /* Footer */
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 0.9rem;
            z-index: 10;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .search-input {
                padding: 15px 20px;
            }
            
            .search-button {
                padding: 11px 20px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 30px;
            }
            
            .hero-logo {
                max-width: 300px;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .search-input {
                padding: 12px 15px;
                font-size: 1rem;
            }
            
            .search-button {
                padding: 9px 15px;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-logo {
                max-width: 250px;
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .search-container {
                padding: 0 15px;
            }
            
            .popular-searches {
                padding: 15px;
                margin-top: 30px;
            }
        }
        
        /* Contenedor de sugerencias */
        .suggestions-list {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #ffffff;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 10px 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 240px;
            overflow-y: auto;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        /* Cada elemento de sugerencia */
        .suggestion-item {
            padding: 12px 18px;
            font-size: 15px;
            color: #222;
            background-color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            border-bottom: 1px solid #f0f0f0;
            text-transform: none;
        }

        /* Capitalizar solo la primera letra */
        .suggestion-item::first-letter {
            text-transform: uppercase;
        }

        /* Efecto hover */
        .suggestion-item:hover {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-open"></i> Planes de Negocios
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Buscar/lista_tesis.php">Planes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Buscar/ranking.php">Ranking</a>
                    </li>
                    
                    <!-- ✅ MENÚS ADMINISTRATIVOS - SOLO SI ESTÁ AUTENTICADO Y TIENE ROL -->
                    <?php if ($estaAutenticado && ($rol == 'admin' || $rol == 'owner')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Admin/gestionar_tesis.php">Gestionar Planes</a>
                    </li>
                    <?php endif; ?>
                    
                    
                    <!-- ✅ BOTÓN DE LOGIN/LOGOUT -->
                    <?php if ($estaAutenticado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/BibliotecaCEDHI/">
                            <i class="fas fa-home"></i> Sistema Central
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-warning">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($usuarioData['nombre'] ?? 'Usuario') ?>
                        </span>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/BibliotecaCEDHI/">
                            <i class="fas fa-sign-in-alt"></i> Salir
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        
        <!-- Carousel de imágenes -->
        <div class="carousel">
            <img src="Imagenes/DJI_0036.jpg" class="active" />
            <img src="Imagenes/NVC_0303.jpg" />
            <img src="Imagenes/NVC_0510.jpg" />
        </div>
        
        <div class="hero-content">
            <img src="Imagenes/logotipob.png" alt="Logo" class="hero-logo" />
            <h1 class="hero-title">Explora nuestro Repositorio de Planes de Negocios</h1>
            <p class="hero-subtitle">Encuentra investigaciones académicas y planes de negocio completos</p>
            
            <div class="search-container" style="position: relative;">
                <form class="search-form" id="search-form" action="Buscar/busqueda_palabra.php" method="GET" autocomplete="off">
                    <input type="text" class="search-input" id="searchparam" name="searchparam"
                        placeholder="Buscar por título, autor o palabras clave..."
                        value="<?= htmlspecialchars($searchparam) ?>" />
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <!-- Contenedor de sugerencias -->
                    <div id="suggestions" class="suggestions-list"></div>
                </form>
            </div>

            <!-- Palabras más buscadas -->
            <?php if ($result_busquedas && $result_busquedas->num_rows > 0): ?>
            <div class="popular-searches">
                <h3><i class="fas fa-fire"></i> Tendencias de búsqueda</h3>
                <div class="search-tags">
                    <?php while ($row = $result_busquedas->fetch_assoc()): ?>
                    <div class="search-tag">
                        <?= htmlspecialchars(ucwords($row['palabra'])) ?>
                        <span class="count"><?= $row['contador'] ?></span>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© <?= date('Y') ?> Repositorio de Planes de Negocios - Todos los derechos reservados</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Carousel automático
        let currentIndex = 0;
        const images = document.querySelectorAll('.carousel img');
        const totalImages = images.length;

        function showNextImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % totalImages;
            images[currentIndex].classList.add('active');
        }

        setInterval(showNextImage, 5000);
        
        // Efecto de escritura para el título
        const heroTitle = document.querySelector('.hero-title');
        const originalText = heroTitle.textContent;
        heroTitle.textContent = '';
        
        let i = 0;
        const typingEffect = setInterval(() => {
            if (i < originalText.length) {
                heroTitle.textContent += originalText.charAt(i);
                i++;
            } else {
                clearInterval(typingEffect);
            }
        }, 100);
    </script>

    <script>
    document.getElementById('searchparam').addEventListener('input', function () {
        const query = this.value.trim();
        const suggestionsBox = document.getElementById('suggestions');

        if (query.length === 0) {
            suggestionsBox.innerHTML = '';
            suggestionsBox.style.display = 'none';
            return;
        }

        fetch('Buscar/buscar_sugerencias.php?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = '';
                if (data.length === 0) {
                    suggestionsBox.style.display = 'none';
                    return;
                }

                data.forEach(word => {
                    const div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.textContent = word;
                    div.addEventListener('click', function () {
                        document.getElementById('searchparam').value = word;
                        suggestionsBox.innerHTML = '';
                        suggestionsBox.style.display = 'none';
                        document.getElementById('search-form').submit();
                    });
                    suggestionsBox.appendChild(div);
                });

                suggestionsBox.style.display = 'block';
            })
            .catch(err => {
                console.error(err);
                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
            });
    });
    </script>
</body>
</html>