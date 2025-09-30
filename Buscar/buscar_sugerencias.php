<?php
// Incluimos la configuración de conexión a la base de datos
include('../Conection/conexion.php'); // Ajusta la ruta si cambias la estructura de carpetas

// Indicamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Verificar si el parámetro 'q' (query) fue recibido vía GET
if (!isset($_GET['q'])) {
    // Si no hay búsqueda, devolvemos un JSON vacío
    echo json_encode([]);
    exit;
}

// Capturamos el término de búsqueda enviado por el usuario
$search = $_GET['q'];

// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    // Si falla la conexión, devolvemos un JSON vacío
    echo json_encode([]);
    exit;
}

// Escapamos el término de búsqueda para evitar inyección SQL
$search = $conn->real_escape_string($search);

/*-----------------------------------------------------------
| Realizamos una consulta a la tabla PalabrasBuscadas
| para obtener hasta 10 sugerencias que comiencen con
| el texto ingresado por el usuario.
|
| Puedes cambiar el patrón a '%$search%' para buscar
| en cualquier parte de la palabra, no solo al inicio.
------------------------------------------------------------*/
$sql = "SELECT palabra FROM PalabrasBuscadas 
        WHERE palabra LIKE '$search%' 
        ORDER BY contador DESC 
        LIMIT 10";

// Ejecutamos la consulta
$result = $conn->query($sql);

// Array para guardar las sugerencias
$words = [];

// Recorremos los resultados y guardamos cada palabra
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $words[] = $row['palabra'];
    }
}

// Devolvemos el array de palabras como un JSON
echo json_encode($words);

// Cerramos la conexión a la base de datos
$conn->close();
?>
