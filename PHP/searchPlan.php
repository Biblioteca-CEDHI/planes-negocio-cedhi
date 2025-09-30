<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados de búsqueda</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome para iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Estilos personalizados */
    body {

      background: url('https://cedhinuevaarequipa.edu.pe/images/Instituto/biblioteca/background.jpg');
      background-repeat: repeat;
      color: #333333;
      font-family: 'Arial', sans-serif;
      padding-top: 60px;
    }
    .navbar {
        position: absolute;
        top: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background: #222222;
        color: white;
        z-index: 10;
        box-sizing: border-box;
    }

    .navbar .logo {
        font-size: 1.5em;
        font-weight: bold;
    }

    .navbar .nav-links {
        display: flex;
        align-items: center;
    }

    .navbar .nav-links a {
        color: white;
        text-decoration: none;
        margin: 0 15px;
        font-size: 1em;
    }

    .navbar .nav-links a:hover {
        text-decoration: underline;
    }

    .navbar .social-icons {
        display: flex;
        align-items: center;
    }

    .navbar .social-icons a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        font-size: 1.2em;
    }

    .navbar .contact-btn {
        padding: 10px 20px;
        background: white;
        color: #222222;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 1em;
    }

    .navbar .contact-btn:hover {
        background: #eee;
    }
    .carousel-container {
      margin-top: 20px; /* Margen superior para el carrusel */
      margin-bottom: 20px; /* Margen inferior para el carrusel */
    }
    .carousel-inner img {
      height: 480px; /* Ajuste de altura para que las imágenes mantengan su proporción */
      object-fit: cover;
    }
    .search-container {
      text-align: center;
      margin-top: 30px; /* Margen superior */
      margin-bottom: 30px; /* Margen inferior */
    }
    .results-container {
      margin-top: 30px; /* Espacio encima de los resultados */
      margin-bottom: 30px; /* Espacio debajo de los resultados */
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .table-responsive {
      max-width: 100%;
      overflow-x: auto;
    }
    .table th {
      background-color: #6d75b3; /* Encabezados de la tabla */
      color: #ffffff; /* Texto blanco */
    }
    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #f2f2f2; /* Fondo de filas impares */
    }
    .carousel-container {
      width: 100%;
    }
    @media (max-width: 576px) {
      .carousel-inner {
        height: 100%;
      }
      .carousel-item img {
        height: 100%;
        object-fit: cover;
      }
    }
    @media (max-width: 576px) {
      .carousel-inner {
        width: 50%;
        margin: 0 auto;
      }
    }
  </style>
</head>
<body>
  
<nav class="navbar">
    <div class="logo">
    CEDHI
    </div>
    <div class="nav-links">
        <a href="../index.php">Inicio</a>
        <a href="listPlan.php">Planes de negocio</a>
    </div>
    <div class="social-icons">
        <a href="https://www.facebook.com/people/CEDHI-Nueva-Arequipa/100057379154452/"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/facebook.png" alt="Facebook"></a>
        <a href="https://api.whatsapp.com/send/?phone=51988806916&text&type=phone_number&app_absent=0"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/whatsapp.png" alt="WhatsApp"></a>
        <!-- <button class="contact-btn">CONTÁCTANOS</button> -->
    </div>
</nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 search-container">
        <h2 class="text-center mb-4">Buscar Planes de negocio</h2>
        <form id="search-form" class="input-group mb-3" action="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/searchBooks" method="GET">
          <input type="text" class="form-control" id="searchparam" name="searchparam" placeholder="Ingrese título del libro, autor...">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button" onclick="document.getElementById('search-form').submit();">Buscar</button>
          </div>
        </form>
        <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/advancedSearch">Busqueda avanzada</a>
      </div>
    </div>

    <div class="row results-container">
      <div class="col-md-12">
                  <h4 class="text-center mb-4">"Plan de negocios"</h4>
                          <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000324">Su majestad el Rocoto</a>
                    <!-- <span class="badge badge-primary">3</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Universidad San Ignacio de Loyola</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Universidad San Ignacio de Loyola</p>
                  <p class="mb-1"><strong>Tema:</strong> GASTRONOMÍA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 188</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001804">QUORUM EDICION N°11 - JUNIO 2019</a>
                    <!-- <span class="badge badge-primary">3</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Jorge Muñiz Ziches</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Una revista del estudio de muñiz</p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 25</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000414">La Gerencia (Tareas, responsabilidades y prácticas)</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Peter F. Drucker</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Editorial &quot;El Ateneo&quot;</p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 2754</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000134">memorias de un amigo casi verdadero</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Ernesto Yepes del Castillo</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Fondo editorial del Congreso del Perú</p>
                  <p class="mb-1"><strong>Tema:</strong> HISTORIA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 3160</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001803">QUORUM EDICION N°07 - JUNIO 2018</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Una revista del estudio de muñiz</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> </p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 25</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000497">MBA &quot;Habilidades personales en los negocios&quot;</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Allan y Bárbara Pease</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Punto y coma editores S.A</p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 125</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000920">Manual de conocimientos básicos para comités de defensa Civil y oficinas de Defensa Civil</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">SINADECI</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Talleres de servicios editoriales y gráficos de FIRMART S.A.C</p>
                  <p class="mb-1"><strong>Tema:</strong> </p>
                  <p class="mb-1"><strong>Páginas:</strong> 157</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000136">Comentarios reales de los Incas</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Inca Garcilazo de la Vega</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Biblioteca Juvenil de Arequipa</p>
                  <p class="mb-1"><strong>Tema:</strong> LITERATURA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 609</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000893">Juan Pablo Viscardo y Guzmán/ Ideólogo y promotor de la Independencia Hispanoamericana</a>
                    <!-- <span class="badge badge-primary">2</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Javier de Belaunde Ruiz de Somocurcio</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Fondo editorial del Congreso del Perú</p>
                  <p class="mb-1"><strong>Tema:</strong> LITERATURA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 223</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
           <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003545">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003465">La artesanía en la sociedad actual</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">C. Laorde, M. Montalvo, J.M. Moreno y R. Rivas</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Salvat editores, S.A.</p>
                  <p class="mb-1"><strong>Tema:</strong> Formacion Humana</p>
                  <p class="mb-1"><strong>Páginas:</strong> 64</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000017">Racismo y mestizaje y otros ensayos</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Gonzalo Portocarrero</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Fondo Editorial del Congreso del Perú</p>
                  <p class="mb-1"><strong>Tema:</strong> CIENCIAS SOCIALES</p>
                  <p class="mb-1"><strong>Páginas:</strong> 405</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003614"></a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">pardo y alicia .Valdelomar . Vallejo. Beingolea. C. Palma .Camino Calderon Gonzales Prada . Garcia Calderon.Alegria Lopez Albujar.Diez Canseco. Ferrando Arguedas. Vargas Vicuña .Izquierdo RIOS.</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> editorial Inca S. A.</p>
                  <p class="mb-1"><strong>Tema:</strong> Literatura</p>
                  <p class="mb-1"><strong>Páginas:</strong> 187</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003544">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000479">MBA&quot;Estrategia de gestión&quot;</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Daniel F. Spulber</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Bresca Editorial</p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 90</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000185">Minas del rey Salomón</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Rider Haggard</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Fondo Editorial Cultura Peruana</p>
                  <p class="mb-1"><strong>Tema:</strong> LITERATURA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 3109</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003598">Antología poética</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Guillermo Mercado</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Biblioteca Juvenil de Arequipa</p>
                  <p class="mb-1"><strong>Tema:</strong> LITERATURA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 3166</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003542">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000485">MBA &quot;Contabilidad de gestión&quot;</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Peter Navarro</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Bresca Editorial</p>
                  <p class="mb-1"><strong>Tema:</strong> CONTABILIDAD</p>
                  <p class="mb-1"><strong>Páginas:</strong> 110</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003541">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000487">MBA &quot;Liderazgo y recursos humanos&quot;</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Steven L. McShane y Mary Ann Von Glinow</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Bresca Editorial</p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 2822</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003540">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001675">Tradiciones y leyendas Arequipeñas</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Antología Básica</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Biblioteca Juvenil de Arequipa</p>
                  <p class="mb-1"><strong>Tema:</strong> LITERATURA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 3150</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001187">Guía de práctica de álgebra y geometría - Facultad de ingeniería y computación</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">José Alberto Carpio Alatrista, Vidal Martín Bolaños, Dugán Nina, Matide Peña,Nancy Quispe, Fredy Tito, Luz Vasquez</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Universidad Católica San Pablo</p>
                  <p class="mb-1"><strong>Tema:</strong> MATEMÁTICA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 2115</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000489">Liderazgo</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Harvard Business Review</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Editorial Planeta Colombiana S.A.</p>
                  <p class="mb-1"><strong>Tema:</strong> ADMINISTRACIÓN</p>
                  <p class="mb-1"><strong>Páginas:</strong> 250</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001189">Guía de práctica de física II - Facultad de ingeniería y computación</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Jim Chávez, Jessica Mosqueira, Lourdes Soria, Wilmer Sucasaire</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Universidad Católica San Pablo</p>
                  <p class="mb-1"><strong>Tema:</strong> FÍSICA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 2113</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001191">Cuaderno de trabajo de introducción a la matemática</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Renzo Acosta,Magaly Alvarez,Freddy Begazo,Mirian Carpio,Jorge Chambi,Jimmy Cruz,Gonzalo Mendoza,Juan Ortega,Christian Ortiz,Matilde Peña,Clauida Salas,Luz Vásquez</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Universidad Católica San Pablo</p>
                  <p class="mb-1"><strong>Tema:</strong> MATEMÁTICA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 2111</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003539">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003538">Officially Dead</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Richard Prescott</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Macmillan Pub. Ltd.</p>
                  <p class="mb-1"><strong>Tema:</strong> Novela</p>
                  <p class="mb-1"><strong>Páginas:</strong> 0</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001195">Guía de prácticas de cálculo en una variable - Facultad de ingeniería y computación</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Magaly Alvarez, Edgar Apaza, Freddy Begazo, Ana Cano, Adela Cano, José Carpio, Dugán Nina,Matilde Peña</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Universidad Católica San Pablo</p>
                  <p class="mb-1"><strong>Tema:</strong> INFORMÁTICA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 2107</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->
                  <!-- Ejemplo de tarjeta -->
          <div class="card mb-3">
              <div class="card-body p-3">
                  <h5 class="card-title mb-1">
                    <a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001674">Tradiciones y leyendas Arequipeñas</a>
                    <!-- <span class="badge badge-primary">1</span> -->
                  </h5>
                  <p class="card-subtitle mb-2 text-muted"><small>por <span class="author">Antología Básica</span></small></p>
                  <p class="mb-1"><strong>Editorial:</strong> Biblioteca Juvenil de Arequipa</p>
                  <p class="mb-1"><strong>Tema:</strong> LITERATURA</p>
                  <p class="mb-1"><strong>Páginas:</strong> 3150</p>
                  <div class="ratings">
                      <!-- Aquí podrías incluir las estrellas de valoración si lo deseas -->
                  </div>
              </div>
          </div>
          <!-- Fin del ejemplo de tarjeta -->


  <!-- Bootstrap JS y dependencias (jQuery y Popper.js) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
