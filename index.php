<?php
include("php/conexion.php");

session_start();

$usser = $_SESSION['cliente'];

$sql = "SELECT correo_electronico, nombre, rol FROM clientes WHERE correo_electronico = '$usser'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc(); // Realiza un recorrido en las filas de nuestra tabla "usuarios"
    $_SESSION['rol'] = $row['rol']; // Guardar el rol en la sesión
    $_SESSION['nombre'] = $row['nombre']; // Guardar el nombre en la sesión si es necesario
} else {
    echo "No se encontró el usuario.";
}

// Verifica si se logró guardar el rol en la sesión
if (!isset($_SESSION['rol'])) {
    echo "No se ha establecido el rol en la sesión.";
}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <script src="script.js" async></script>

    <title>Sistema de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>



    <header>
        <h1>Sistema de ventas</h1>
        <div class="user" style="color: white; font-size:1.5rem;" >
            <button class="navbar-toggler fs-3 m-5" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <svg xmlns="http://www.w3.org/2000/svg" style="color: white;" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
            </button>

            <?php
                echo htmlspecialchars($row['rol'], ENT_QUOTES, 'UTF-8');
                echo ': ';
                echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8');
            ?>
        </div>


       
        <style>
            #men{
                position: relative;
                justify-content: center;
            }
            .buscador{
                position: absolute;
                top: 9rem;
                left: 35%; 
            }
            .hi{
                position: relative;
            }
            #bus{
                float: left;
                margin-right: 0px;
            }
            .user{
                position: absolute;
                top: -1rem;
            }
          
        </style>

        <div class="hi">
          <div class="buscador">
            <input type="search" id="bus" class="form-control" style="width: 20rem;">
            <button type="submit" class="btn btn-light">Buscar</button>
          </div>
        </div>



        <?php
        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
            // Mostrar contenido solo para administradores
            echo '<div class="agre" style="text-align: right; margin-top: 20px;">';
            echo '<a href="agregar_producto.html" class="btn btn-success">Agregar Producto</a>';
            echo '</div>';
        } else {
            echo '<p>No tienes permisos para ver esta sección.</p>';
        }

	    ?>

        <style>
            .agre{
                position: absolute;
                top: 1rem;
                right: 3rem;
            }
        </style>

    </header>
    <!-- Contenido de la tienda -->
    <section class="contenedor">
   
        <div class="contenedor-items ">
            <?php
            // Conexión a la base de datos
            $conexion = new mysqli("localhost", "root", "", "olimpiadas");

            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }

            // Consulta para obtener los productos
            $sql = "SELECT nombre, imagen, descripcion, precio, deporte FROM productos";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                // Salida de datos de cada fila
                 while($fila = $resultado->fetch_assoc()) {
                    echo '<div class="item" data-deporte="' . htmlspecialchars($fila["deporte"]) . '">';
                    echo '<span class="titulo-item">' . htmlspecialchars($fila["nombre"]) . '</span>';
                    echo '<img src="' . htmlspecialchars($fila["imagen"]) . '" alt="' . htmlspecialchars($fila["nombre"]) . '" class="img-item">';
                    echo '<div class="des">' . htmlspecialchars($fila["descripcion"]) . '</div>';
                    echo '<span class="precio-item">$' . number_format($fila["precio"], 0, ',', '.') . '</span>';
                    echo '<div class="deporte">' . htmlspecialchars($fila["deporte"]) . '</div>';
                    echo '<button class="boton-item">Agregar al Carrito</button>';
                    echo '</div>';
                 }
            } else {
                echo "No se encontraron productos.";
            }

            // Cerrar la conexión
            $conexion->close();
            ?>
        </div>

        <div class="carrito" id="carrito">
        <div class="header-carrito">
                <h2>Tu Carrito</h2>
            </div>
        
        <div class="carrito-items">
        </div>

        <div class="carrito-total">
                <div class="fila">
                    <strong>Tu Total</strong>
                    <span class="carrito-precio-total">
                        $120.000,00
                    </span>
                </div>
                <button class="btn-pagar">Pagar <i class="fa-solid fa-bag-shopping"></i> </button>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  

</body>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('bus');
    const searchButton = document.querySelector('.btn-light');
    const items = document.querySelectorAll('.item');

    const filterItems = () => {
        const searchTerm = searchInput.value.toLowerCase();
        items.forEach(item => {
            const deporte = item.getAttribute('data-deporte').toLowerCase();
            if (deporte.includes(searchTerm) || searchTerm === '') {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    };

    searchButton.addEventListener('click', filterItems);
    searchInput.addEventListener('input', filterItems);
});
</script>

</html>
