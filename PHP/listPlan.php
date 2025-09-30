<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Planes de negocio</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('https://cedhinuevaarequipa.edu.pe/images/Instituto/biblioteca/background.jpg');
            background-repeat: repeat;
            color: #333333;
            font-family: 'Arial', sans-serif;
            padding-top: 60px;
            /* background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Arial', sans-serif;
            padding-top: 60px; */
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
        .table-container {
            margin-top: 30px;
        }
        .update-button {
            text-align: right;
            margin-bottom: 10px;
        }
        .container {
            background-color: #f8f9fa;
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

<div class="container table-container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Lista de Planes de negocio</h2>
            <div class="update-button">
                <button type="button" class="btn btn-secondary" onclick="location.href='https://cedhinuevaarequipa.edu.pe/catalogo-web/public/bookListUpdate'">Actualizar</button>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Año</th>
                        <th>País</th>
                        <th>Idioma</th>
                    </tr>
                </thead>
                <tbody>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001302">-</a></td>
                            <td>Cardenal Paúl Poupard</td>
                            <td></td>
                            <td>Arequipa</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000531">101 métodos para generar ideas</a></td>
                            <td>T.R. Foster</td>
                            <td>2002</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000564">10 Tecnologías que están cambiando el mundo de los negocios</a></td>
                            <td>Semana Económica (Revista)</td>
                            <td>2015</td>
                            <td></td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001247">180 Menús ricos y nutritivos T10</a></td>
                            <td>Angelica Saaki</td>
                            <td>2008</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001248">180 Menús ricos y nutritivos T11</a></td>
                            <td>Angelica Sasaki</td>
                            <td>2008</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001211">180 Menús ricos y nutritivos T12</a></td>
                            <td>Angelica Sasaki</td>
                            <td>2008</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001808">180 menús ricos y nutritivos TOMO 10</a></td>
                            <td>Angelica Sasaki</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001809">180 menús ricos y nutritivos TOMO 12</a></td>
                            <td>Angelica Sasaki</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000907">2000 years of chinese ceramics</a></td>
                            <td>Valrae Reynolds Phillip H.Curtis Yen Fen Pei</td>
                            <td>1977</td>
                            <td>China</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000687">20 Historias, 20 Momentos</a></td>
                            <td>Telefónica</td>
                            <td>2014</td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000159">6 amigos van al Colca</a></td>
                            <td>Beatriz Canny De Bustamante</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000160">6 amigos van al Colca</a></td>
                            <td>Beatriz Canny De Bustamante</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000083">7 Ensayos de interpretación de la Realidad Peruana</a></td>
                            <td>José Carlos Mariátegui</td>
                            <td>2004</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003429">a</a></td>
                            <td>Edelnor</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001811">Abran las puertas de la misericordia</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003485">Acepta el cambio para lograr el éxito</a></td>
                            <td>DALE CARNEGIE</td>
                            <td>2021</td>
                            <td>México</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000682">Actas del Congreso Internacional Histórico</a></td>
                            <td>Arzobispado de Arequipa</td>
                            <td>2013</td>
                            <td>Arequipa</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000683">Actas del Congreso Internacional Histórico</a></td>
                            <td>Arzobispado de Arequipa</td>
                            <td>2013</td>
                            <td>Arequipa</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000684">Actas del Congreso Internacional Histórico</a></td>
                            <td>Arzobispado de Arequipa</td>
                            <td>2013</td>
                            <td>Arequipa</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001354">Actas del Congreso Internacional Histórico-Teológico Pastoral</a></td>
                            <td>Arzobispado de Arequipa</td>
                            <td>2013</td>
                            <td>Arequipa</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000371">Actividad coboral</a></td>
                            <td>Instituto Pacifíco S.A.C</td>
                            <td>2011</td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000577">Actualidad Contable</a></td>
                            <td>Instituto Pacífico S.A.C</td>
                            <td>2012</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000455">Actualidad Laboral</a></td>
                            <td>Instituto Pacífico S.A.C</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000578">Actualidad Tributaria</a></td>
                            <td>Instituto Pacífico S.A.C</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000018">Adaptación: Edipo Rey. Edipo en Colona. Electra</a></td>
                            <td>Sófocles-Eurípides</td>
                            <td>1994</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001813">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001818">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001814">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001812">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001817">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001815">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001816">ADEPIA ED. N°40</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001819">ADEPIA ED. N°41</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000266">Adios al barrio</a></td>
                            <td>José Antonio Galloso</td>
                            <td>2010</td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000872">Adiós a Mariátegui (Pensar el Perú en perspectiva postmoderna)</a></td>
                            <td>José Ignacio López Soria</td>
                            <td>2007</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000873">Adiós a Mariátegui (Pensar el Perú en perspectiva postmoderna)</a></td>
                            <td>José Ignacio López Soria</td>
                            <td>2007</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000871">Adiós a Mariátegui (Pensar el Perú en perspectiva postmoderna)</a></td>
                            <td>José Ignacio López Soria</td>
                            <td>2007</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001807">¿Adivina quien soy?</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001820">Administracion Financiera</a></td>
                            <td>W. Johnson</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000555">Administración financiera</a></td>
                            <td>Robert W. Johnson</td>
                            <td>1980</td>
                            <td>-</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001821">AGENDA GOURMET Y DEL PAN 2017</a></td>
                            <td>Esagsac Comunicadores</td>
                            <td></td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001822">AGILE BANKING N°17 SEPTIEMBRE-OCTUBRE 2018</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000816">Agua. Los escoleros Warma Kuyay Oda al Jet ¿Qué es el flolkore? No soy un aculturado</a></td>
                            <td>Jose Maria Arguedas</td>
                            <td>1988</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000251">A History of our Country</a></td>
                            <td>David Saville Muzzley</td>
                            <td>1946</td>
                            <td>Boston</td>
                            <td>Inglés</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000299">Ahuacate- Historia realidad y sueños de la palta</a></td>
                            <td>Walter H. Wust</td>
                            <td>2016</td>
                            <td>Lima</td>
                            <td>ESPAÑOL/INGLÉS</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000323">Ajíes del Perú</a></td>
                            <td>Backus</td>
                            <td>2006</td>
                            <td>-</td>
                            <td>ESPAÑOL/INGLÉS</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000049">A la hora de la tarde y de los juegos</a></td>
                            <td>Edgardo Rivera Martínez</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000093">Aldea encantada</a></td>
                            <td>Abraham Valdelomar</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000092">Aldea encantada</a></td>
                            <td>Abraham Valdelomar</td>
                            <td>2011</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000037">Alforja del Jorobado</a></td>
                            <td>Rosa Cerna Guardia</td>
                            <td>2010</td>
                            <td>Lima</td>
                            <td>Español</td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1001823">ALICIA EN EL PAIS DE LAS MARAVILLAS</a></td>
                            <td>Lewis Carroll</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1000397">Alivie y prevenga los dolores de cabeza</a></td>
                            <td>Harvard Health Publications</td>
                            <td>2009</td>
                            <td></td>
                            <td></td>
                        </tr>
                                            <tr>
                            <td><a href="https://cedhinuevaarequipa.edu.pe/catalogo-web/public/libros/1003417">Alle radici del capitalismo</a></td>
                            <td>Oreste Bazzichi</td>
                            <td>2003</td>
                            <td>-</td>
                            <td>Portugues</td>
          
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS y dependencias (jQuery y Popper.js) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>