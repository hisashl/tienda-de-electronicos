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
    <link rel="stylesheet" href="../styles/cliente.css">
    <title>Pedidos</title>
    <script src="https://kit.fontawesome.com/fa5913e7cf.js" crossorigin="anonymous"></script>
</head>

<body>

    <div id="logout">
        <a href="menu.php">
            <i class="fa-solid fa-arrow-left fa-3x"></i>
            Regresar
        </a>
    </div>

    <div id="box" class="center">
        <div class="inside">
            <h1>Busqueda de facturas:</h1>
            <form id="busqueda" method="post">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="search" type="text" name="search" required>
                Dato:
                <select name="dato" for="busqueda" required>
                    <option value="PK_factura">No. Factura</option>
                    <option value="FK_empleado">No. Empleado</option>
                    <option value="FK_cliente">No. Cliente</option>
                    <option value="fecha">Fecha</option>
                    <option value="total">Total</option>

                </select>
                <input type="submit" name="enviar" value="Buscar">
            </form>

            <form method="post">
                <input type="submit" name="agregar" value="Agregar">
            </form>

            <form method="post">
                <input type="submit" name="todos" value="Mostrar Todos">
            </form>


            <table id="hide" class="hidden">
                <thead>
                    <th>No. Factura</th>
                    <th>Empleado</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <?php

                    if (isset($_POST['enviar'])) {

                        $busqueda = trim($_POST['search']);
                        $columna = $_POST['dato'];

                        $query = "SELECT * FROM `factura` WHERE $columna LIKE '%$busqueda%'";
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
                                    <td>
                                        <?php
                                        $cliente = $data['FK_cliente'];
                                        $sub = "SELECT nombre, apep FROM `cliente` WHERE PK_codigo='$cliente'";
                                        $res2 = mysqli_query($conn, $sub);
                                        $data2 = mysqli_fetch_assoc($res2);
                                        echo $data2['nombre'] . ' ' . $data2['apep'];
                                        ?>
                                    </td>
                                    <td><?php echo $data['fecha'] ?: ''; ?></td>
                                    <td><?php echo $data['total'] ?: ''; ?></td>

                                    <td>
                                        <form method="post">
                                            <input id="mod" type="submit" name="ver" value="Ver productos">
                                            <input type="hidden" name="id" value="<?php echo $data['PK_factura'] ?: ''; ?>">
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
                            echo "<script type = 'text/javascript'>
                            document.getElementById('hide').classList.remove('hidden');
                            </script>";
                        } else {
                            echo "No se encontraron resultados";
                        }
                    }
                    ?>

                </tbody>
            </table>

            <table id="todos" class="hidden">
                <thead>
                    <th>No. Factura</th>
                    <th>Empleado</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <?php

                    $query = "SELECT * FROM `factura`";
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
                                <td>
                                    <?php
                                    $cliente = $data['FK_cliente'];
                                    $sub = "SELECT nombre, apep FROM `cliente` WHERE PK_codigo='$cliente'";
                                    $res2 = mysqli_query($conn, $sub);
                                    $data2 = mysqli_fetch_assoc($res2);
                                    echo $data2['nombre'] . ' ' . $data2['apep'];
                                    ?>
                                </td>
                                <td><?php echo $data['fecha'] ?: ''; ?></td>
                                <td><?php echo $data['total'] ?: ''; ?></td>

                                <td>
                                    <form method="post">
                                        <input id="mod" type="submit" name="ver" value="Ver productos">
                                        <input type="hidden" name="id" value="<?php echo $data['PK_factura'] ?: ''; ?>">
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

            <form id="add" class="hidden" method="post">
                <h1>Nueva factura</h1>
                <div class="campo">
                    <select name="empleado" id="emp">
                        <?php
                        $query = "SELECT * FROM `empleado`";
                        $res = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($res)) {
                        ?>
                            <option value="<?php echo $row['PK_matricula'] ?: ''; ?>"> <?php echo $row['nombre'] . ' ' . $row['apep'] . ' ' . $row['apem']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="emp">Empleado</label>
                </div>

                <div class="campo">
                    <select name="cliente" id="cli">
                        <?php
                        $query = "SELECT * FROM `cliente`";
                        $res = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <option value="<?php echo $row['PK_codigo'] ?: ''; ?>"> <?php echo $row['nombre'] . ' ' . $row['apep'] . ' ' . $row['apem']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="cli">Cliente</label>
                </div>

                <div class="campo">
                    <input type="date" name="fecha" id="fec" required>
                    <label for="fec">Fecha</label>
                </div>

                <input type="submit" name="add" value="Agregar">

            </form>



            <!-- Form para modificar descripcion de factura -->
            <form id="mod_prod" class="hidden" method="post">
                <h1>Modificar cantidad</h1>

                <div class="campo">
                    <select name="producto" id="prod">
                        <?php
                        $query = "SELECT * FROM `producto`";
                        $res = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($res)) {
                        ?>
                            <option value="<?php echo $row['PK_codigo'] ?: ''; ?>"> <?php echo $row['nombre']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="prod">Producto</label>
                </div>

                <div class="campo">
                    <input id="num" type="number" name="cantidad" required>
                    <label for="num">Cantidad</label>
                </div>

                <div class="campo">
                    <input type="submit" name="mod_des" value="Modificar producto">
                </div>

            </form>

            <?php
            include "bd.php";

            if (isset($_POST['agregar'])) {
                echo "<script type = 'text/javascript'>
                    document.getElementById('add').classList.remove('hidden');
                    </script>";
            }

            if (isset($_POST['todos'])) {
                echo "<script type = 'text/javascript'>
                    document.getElementById('todos').classList.remove('hidden');
                    </script>";
            }

            if (isset($_POST['add'])) {
                $empleado = trim($_POST['empleado']);
                $cliente = trim($_POST['cliente']);
                $fecha = trim($_POST['fecha']);


                $query = "INSERT INTO `factura`(`FK_empleado`, `FK_cliente`, `fecha`) VALUES ('$empleado','$cliente','$fecha')";
                mysqli_query($conn, $query) or die("error en la consulta");
            }

            if (isset($_POST['ver'])) {
                session_reset();
                $_SESSION['id'] = $_POST['id'];
            ?>
                <div id="producto">

                    <form id="modify" method="post">
                        <h1>Agregar producto</h1>
                        <div class="campo">
                            <select name="producto" id="prod">
                                <?php
                                $query = "SELECT * FROM `producto`";
                                $res = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_array($res)) {
                                ?>
                                    <option value="<?php echo $row['PK_codigo'] ?: ''; ?>"> <?php echo $row['nombre']; ?> </option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="prod">Producto</label>
                        </div>

                        <div class="campo">
                            <input type="number" name="cantidad" id="can" min="1" max="9" required>
                            <label for="can">Cantidad</label>
                        </div>

                        <input type="submit" name="mod" value="Agregar producto">
                        <input type="hidden" name="id" value="<?php echo $_POST['id'] ?: ''; ?>">
                    </form>


                    <table id="del_prod">
                        <h1>Modificar producto</h1>
                        <thead>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                            <?php
                            $id = $_POST['id'];
                            $query = "SELECT * FROM `des_factura` WHERE FK_factura='$id'";
                            $res = mysqli_query($conn, $query) or die('Error en la consulta');

                            if ($res->num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $producto = $data['FK_producto'];
                                            $sub = "SELECT nombre FROM `producto` WHERE PK_codigo='$producto'";
                                            $res2 = mysqli_query($conn, $sub);
                                            $data2 = mysqli_fetch_assoc($res2);
                                            echo $data2['nombre'];
                                            ?>
                                        </td>
                                        <td><?php echo $data['cantidad'] ?: ''; ?></td>
                                        <td><?php echo $data['subtotal'] ?: ''; ?></td>
                                        <td>
                                            <form method="post">
                                                <input id="mod" type="submit" name="modificar" value="Modificar">
                                                <input type="hidden" name="id_del" value="<?php echo $data['PK_des'] ?: ''; ?>">
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post">
                                                <input id="mod" type="submit" name="eliminar" value="Borrar">
                                                <input type="hidden" name="id" value="<?php echo $data['PK_des'] ?: ''; ?>">
                                            </form>
                                        </td>
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

            if (isset($_POST['mod'])) {

                $id = $_POST['id'];
                $producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];


                $sub = "SELECT `precio` FROM `producto` WHERE PK_codigo='$producto'";
                $res = mysqli_query($conn, $sub);
                $dato = mysqli_fetch_assoc($res);

                $subtotal = $dato['precio'] * intval($cantidad);

                $query = "INSERT INTO `des_factura`(`FK_factura`,`FK_producto`,`cantidad`, `subtotal`) VALUES ('$id', '$producto', '$cantidad', '$subtotal')";
                mysqli_query($conn, $query) or die("ERROR");
            }

            if (isset($_POST['borrar_producto'])) {
                echo "<script type = 'text/javascript'>
                            document.getElementById('del_prod').classList.remove('hidden');
                            </script>";

                $_SESSION['id_des'] = $_POST['id'];
            }

            if (isset($_POST['eliminar'])) {
                $id = $_POST['id'];
                $query = "DELETE FROM `des_factura` WHERE `PK_des`='$id'";
                mysqli_query($conn, $query);
            }

            if (isset($_POST['borrar'])) {
                $id = $_POST['id'];
                $query = "DELETE FROM `factura` WHERE `PK_factura`='$id'";
                mysqli_query($conn, $query);
            }

            if (isset($_POST['modificar'])) {
                echo "<script type = 'text/javascript'>
                            document.getElementById('mod_prod').classList.remove('hidden');
                            </script>";
                $_SESSION['id_des'] = $_POST['id_del'];
            }

            if (isset($_POST['mod_des'])) {
                $id = $_SESSION['id_des'];
                $producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];

                $sub = "SELECT `precio` FROM `producto` WHERE PK_codigo='$producto'";
                $res = mysqli_query($conn, $sub);
                $dato = mysqli_fetch_assoc($res);

                $subtotal = $dato['precio'] * intval($cantidad);

                $query = "UPDATE `des_factura` SET `FK_producto`='$producto',`cantidad`='$cantidad',`subtotal`='$subtotal' WHERE `PK_des`='$id'";
                mysqli_query($conn, $query);
            }

            mysqli_close($conn);
            ?>

        </div>
    </div>
</body>

</html>