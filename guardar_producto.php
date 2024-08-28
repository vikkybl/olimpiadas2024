<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'olimpiadas');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$deporte = $_POST['deporte'];
$imagen = $_FILES['imagen']['name'];

// Guardar la imagen en el servidor
$directorio = "img/";
$ruta_imagen = $directorio . basename($imagen);

if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
    // Preparar la consulta SQL
    $sql = "INSERT INTO productos (nombre, descripcion, precio, deporte, imagen) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $nombre, $descripcion, $precio, $deporte, $ruta_imagen);

    if ($stmt->execute()) {
        echo "Producto agregado exitosamente.";        
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al cargar la imagen.";
}




$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <br>
<button type="submit" class="btn btn-primary"><a href="index.php" style="color: white;">volver a la pantalla principal</a></button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
