<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$correo_electronico = $_POST['correo_electronico'];
$contrasena = $_POST['contrasena'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

$contrasena = hash('sha512', $contrasena);


// Depuración: Verifica si los datos están llegando correctamente
var_dump($_POST);

$fecha_registro = date('Y-m-d H:i:s');

$nombre = mysqli_real_escape_string($conexion, $nombre);
$correo_electronico = mysqli_real_escape_string($conexion, $correo_electronico);
$direccion = mysqli_real_escape_string($conexion, $direccion);
$telefono = mysqli_real_escape_string($conexion, $telefono);

$validar_email = mysqli_query($conexion, "SELECT * FROM clientes WHERE correo_electronico = '$correo_electronico' and contrasena = '$contrasena' ");
if (mysqli_num_rows($validar_email) > 0) {
    echo '
    <script>
    alert("El email ya existe");
    window.location = "../registro.html";
    </script>
    ';
    exit();
}

$sql = "INSERT INTO clientes (nombre, correo_electronico, contrasena, direccion, telefono, fecha_registro) 
        VALUES ('$nombre', '$correo_electronico', '$contrasena', '$direccion', '$telefono', '$fecha_registro')";

$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo '
    <script>
    alert("Usuario registrado correctamente");
    window.location = "../index.php";
    </script>
    ';
} else {
    echo '
    <script>
    alert("Error al registrar el usuario: ' . mysqli_error($conexion) . '");
    window.location = "../registro.html";
    </script>
    ';
}

mysqli_close($conexion);
?>
