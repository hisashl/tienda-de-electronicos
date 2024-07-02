<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="../styles/empleado.css">
    <script src="https://kit.fontawesome.com/fa5913e7cf.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="logout">
        <a href="../index.php">
            <i class="fa-solid fa-right-from-bracket fa-3x"></i>
            Cerrar Sesion
        </a>
    </div>
    <div id="title">
        <h1>Seleccione una opcion:</h1>
    </div>
    <div id="menu" class="menu">
        <div class="item">
            <a href="cliente.php" class="clickable">
                <h1>Clientes</h1>
                <i class="fa-solid fa-user fa-9x"></i>
            </a>
        </div>
        <div class="item">
            <a href="producto.php" class="clickable">
                <h1>Productos</h1>
                <i class="fa-solid fa-list fa-9x"></i>
            </a>
        </div>
        <div class="item">
            <a href="pedido.php" class="clickable">
                <h1>Facturas</h1>
                <i class="fa-solid fa-receipt fa-9x"></i>
            </a>
        </div>
        <div class="item">
            <a href="empleado.php" class="clickable">
                <h1>Empleados</h1>
                <i class="fa-solid fa-user-group fa-9x"></i>
            </a>
        </div>
    </div>

</body>

</html>