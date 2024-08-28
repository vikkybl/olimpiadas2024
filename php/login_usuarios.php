<?php
session_start();
include("conexion.php");
include("registro_usuario.php");
include("registro.html");



$correo_electronico = $_POST['correo_electronico'];
$contrasena = $_POST['contrasena'];


// Depuración: Verifica si los datos están llegando correctamente
var_dump($_POST);

$correo_electronico = mysqli_real_escape_string($conexion, $correo_electronico);

$validar_login = mysqli_query($conexion, "SELECT * FROM clientes WHERE correo_electronico='$correo_electronico'");

if (mysqli_num_rows($validar_login) > 0) {
    $_SESSION['cliente'] = $correo_electronico; // Guarda el usuario que ingresó
    header("Location: ../index.php");
    exit();
} else {
    echo '
    <script>
    alert("La cuenta no existe, por favor regístrate.");
    window.location = "../registro.html";
    </script>
    ';
    exit();
}
?>
