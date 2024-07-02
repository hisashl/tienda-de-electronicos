<!DOCTYPE html>
<html lang="en">

<?php
include 'bd.php';
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Mis pedidos:</title>
    <script src="https://kit.fontawesome.com/fa5913e7cf.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="logout">
        <a href="../index.php">
            <i class="fa-solid fa-right-from-bracket fa-3x"></i>
            Cerrar Sesion
        </a>
    </div>

    <div id="box" class="center">
        <div class="inside">
            <h1>Mis pedidos:</h1>

            <div id="todos"></div>
            <table>
                <thead>
                    <th>No. Pedido</th>
                    <th>Empleado</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <?php
                    $email = $_SESSION['email'];
                    $sub = "SELECT PK_codigo FROM cliente WHERE correo='$email'";
                    $res2 = mysqli_query($conn, $sub);
                    $data2 = mysqli_fetch_assoc($res2);
                    $FK_cliente = $data2['PK_codigo'];

                    $query = "SELECT * FROM `factura` WHERE FK_cliente='$FK_cliente'";
                    $res = mysqli_query($conn, $query) or die('Error en la consulta');

                    if ($res->num_rows > 0) {
                        while ($data = mysqli_fetch_assoc($res)) {
                    ?>
                            <tr>
                                <td><?php echo $data['PK_factura'] ?: ''; ?></td>
                                <td>
                                    <?php
                                    $empleado = $data['FK_empleado'];
                                    $sub = "SELECT nombre, apep FROM `empleado` WHERE PK_matricula='$empleado'";
                                    $res2 = mysqli_query($conn, $sub);
                                    $data2 = mysqli_fetch_assoc($res2);
                                    echo $data2['nombre'] . ' ' . $data2['apep'];
                                    ?>
                                </td>
                                <td><?php echo $data['fecha'] ?: ''; ?></td>
                                <td><?php echo $data['total'] ?: ''; ?></td>

                                <td>
                                    <form method="post">
                                        <input id="mod" type="submit" name="mostrar" value="Mostrar Productos">
                                        <input type="hidden" name="id" value="<?php echo $data['PK_factura'] ?: '';?>">
                                    </form>
                                </td>

                                <td>
                                    <form method="post">
                                        <input id="mod" type="submit" name="borrar" value="Borrar">
                                        <input type="hidden" name="id" value="<?php echo $data['PK_factura'] ?: ''; ?>">
                                    </form>
                                </td>

                            </tr>
                    <?php

                        }
                    }


                    ?>

                </tbody>
            </table>

            <?php

            if (isset($_POST['mostrar'])) {
            ?>
                <div id="prod">
                    <table>
                        <h1>Productos:</h1>
                        <thead>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                            <?php
                            $id = $_POST['id'];
                            $query = "SELECT * FROM `des_factura` WHERE `FK_factura`='$id'";
                            $res = mysqli_query($GLOBALS['conn'], $query) or die('Error en la consulta');

                            if ($res->num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $producto = $data['FK_producto'];
                                            $sub = "SELECT nombre FROM `producto` WHERE PK_codigo='$producto'";
                                            $res2 = mysqli_query($GLOBALS['conn'], $sub);
                                            $data2 = mysqli_fetch_assoc($res2);
                                            echo $data2['nombre'];
                                            ?>
                                        </td>
                                        <td><?php echo $data['cantidad'] ?: ''; ?></td>
                                        <td><?php echo $data['subtotal'] ?: ''; ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            }

            if (isset($_POST['borrar'])) {
                $id = $_POST['id'];
                $query = "DELETE FROM `factura` WHERE `PK_factura`='$id'";
                mysqli_query($conn, $query);
            }
            mysqli_close($conn);
            ?>
            
        </div>
    </div>

</body>

</html>