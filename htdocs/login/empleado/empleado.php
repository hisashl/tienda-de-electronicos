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
    <title>Empleados</title>
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
            <h1>Busqueda de empleados:</h1>
            <form id="busqueda" method="post">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="search" type="text" name="search" required>
                Dato:
                <select name="dato" for="busqueda" required>
                    <option value="PK_matricula">Matricula</option>
                    <option value="nombre">Nombre</option>
                    <option value="apep">Apellido Paterno</option>
                    <option value="apem">Apellido Materno</option>
                    <option value="fecha">Fecha Ingreso</option>
                    <option value="turno">Turno</option>
                    <option value="telefono">Telefono</option>
                    <option value="direccion">Direccion</option>
                    <option value="correo">Correo</option>
                    <option value="departamento">Departamento</option>
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
                    <th>Maticula</th>
                    <th>Nombre</th>
                    <th>Ape Paterno</th>
                    <th>Ape Materno</th>
                    <th>Fecha ingreso</th>
                    <th>Turno</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Correo</th>
                    <th>Departamento</th>
                </thead>
                <tbody>
                    <?php

                    if (isset($_POST['enviar'])) {

                        $busqueda = trim($_POST['search']);
                        $columna = $_POST['dato'];



                        $query = "SELECT * FROM `empleado` WHERE $columna LIKE '%$busqueda%'";

                        $res = mysqli_query($conn, $query) or die('Error en la consulta');

                        if ($res->num_rows > 0) {
                            while ($data = mysqli_fetch_assoc($res)) {
                    ?>
                                <tr>
                                    <td><?php echo $data['PK_matricula'] ?: ''; ?></td>
                                    <td><?php echo $data['nombre'] ?: ''; ?></td>
                                    <td><?php echo $data['apep'] ?: ''; ?></td>
                                    <td><?php echo $data['apem'] ?: ''; ?></td>
                                    <td><?php echo $data['fecha_ingreso'] ?: ''; ?></td>
                                    <td><?php echo $data['turno'] ?: ''; ?></td>
                                    <td><?php echo $data['telefono'] ?: ''; ?></td>
                                    <td><?php echo $data['direccion'] ?: ''; ?></td>
                                    <td><?php echo $data['correo'] ?: ''; ?></td>
                                    <td><?php
                                        $depa = $data['FK_depa'];
                                        $sub = "SELECT nombre FROM `departamento` WHERE PK_codigo='$depa'";
                                        $res2 = mysqli_query($conn, $sub);
                                        $data2 = mysqli_fetch_assoc($res2);
                                        echo $data2['nombre'];
                                        ?></td>

                                    <td>
                                        <form method="post">
                                            <input id="mod" type="submit" name="modificar" value="Modificar">
                                            <input type="hidden" name="id" value="<?php echo $data['PK_matricula'] ?: ''; ?>">
                                        </form>
                                    </td>

                                    <td>
                                        <form method="post">
                                            <input id="mod" type="submit" name="borrar" value="Borrar">
                                            <input type="hidden" name="id" value="<?php echo $data['PK_matricula'] ?: ''; ?>">
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
                    <th>Maticula</th>
                    <th>Nombre</th>
                    <th>Ape Paterno</th>
                    <th>Ape Materno</th>
                    <th>Fecha ingreso</th>
                    <th>Turno</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Correo</th>
                    <th>Departamento</th>
                </thead>
                <tbody>
                    <?php


                    $query = "SELECT * FROM `empleado`";
                    $res = mysqli_query($conn, $query) or die('Error en la consulta');

                    if ($res->num_rows > 0) {
                        while ($data = mysqli_fetch_assoc($res)) {
                    ?>
                            <tr>
                                <td><?php echo $data['PK_matricula'] ?: ''; ?></td>
                                <td><?php echo $data['nombre'] ?: ''; ?></td>
                                <td><?php echo $data['apep'] ?: ''; ?></td>
                                <td><?php echo $data['apem'] ?: ''; ?></td>
                                <td><?php echo $data['fecha_ingreso'] ?: ''; ?></td>
                                <td><?php echo $data['turno'] ?: ''; ?></td>
                                <td><?php echo $data['telefono'] ?: ''; ?></td>
                                <td><?php echo $data['direccion'] ?: ''; ?></td>
                                <td><?php echo $data['correo'] ?: ''; ?></td>
                                <td><?php
                                    $depa = $data['FK_depa'];
                                    $sub = "SELECT nombre FROM `departamento` WHERE PK_codigo='$depa'";
                                    $res2 = mysqli_query($conn, $sub);
                                    $data2 = mysqli_fetch_assoc($res2);
                                    echo $data2['nombre'];
                                    ?></td>

                                <td>
                                    <form method="post">
                                        <input id="mod" type="submit" name="modificar" value="Modificar">
                                        <input type="hidden" name="id" value="<?php echo $data['PK_matricula'] ?: ''; ?>">
                                    </form>
                                </td>

                                <td>
                                    <form method="post">
                                        <input id="mod" type="submit" name="borrar" value="Borrar">
                                        <input type="hidden" name="id" value="<?php echo $data['PK_matricula'] ?: ''; ?>">
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
                <h1>Nuevo empleado</h1>
                <div class="campo">
                    <input type="text" name="nombre" id="nom" required>
                    <label for="nom">Nombre</label>
                </div>

                <div class="campo">
                    <input type="text" name="apep" id="ap" required>
                    <label for="ap">Apellido Paterno</label>
                </div>

                <div class="campo">
                    <input type="text" name="apem" id="am" required>
                    <label for="am">Apellido Materno</label>
                </div>

                <div class="campo">
                    <input type="date" name="fecha" id="date">
                    <label for="date">Fecha de ingreso</label>
                </div>

                <div class="campo">
                    <input type="text" name="turno" id="turno" required>
                    <label for="turno">Turno</label>
                </div>

                <div class="campo">
                    <input type="text" name="telefono" id="tel" required>
                    <label for="tel">Telefono</label>
                </div>


                <div class="campo">
                    <input type="text" name="direccion" id="dir" required>
                    <label for="dir">Direccion</label>
                </div>

                <div class="campo">
                    <input type="text" name="correo" id="cor" required>
                    <label for="cor">Correo</label>
                </div>

                <div class="campo">
                    <select name="departamento" id="dep">
                        <option value="1">RH</option>
                        <option value="2">Ventas</option>
                        <option value="3">Gerencia</option>
                        <option value="4">Almacen</option>
                    </select>
                    <label for="dep">Departamento</label>
                </div>

                <input type="submit" name="add" value="Agregar">

            </form>

            <form id="modify" class="hidden" method="post">
                <h1>Modificar empleado</h1>
                <div class="campo">
                    <input type="text" name="nombre" id="nom" required>
                    <label for="nom">Nombre</label>
                </div>

                <div class="campo">
                    <input type="text" name="apep" id="ap" required>
                    <label for="ap">Apellido Paterno</label>
                </div>

                <div class="campo">
                    <input type="text" name="apem" id="am" required>
                    <label for="am">Apellido Materno</label>
                </div>

                <div class="campo">
                    <input type="date" name="fecha" id="date">
                    <label for="date">Fecha de ingreso</label>
                </div>

                <div class="campo">
                    <input type="text" name="turno" id="turno" required>
                    <label for="turno">Turno</label>
                </div>

                <div class="campo">
                    <input type="text" name="telefono" id="tel" required>
                    <label for="tel">Telefono</label>
                </div>


                <div class="campo">
                    <input type="text" name="direccion" id="dir" required>
                    <label for="dir">Direccion</label>
                </div>

                <div class="campo">
                    <input type="text" name="correo" id="cor" required>
                    <label for="cor">Correo</label>
                </div>

                <div class="campo">
                    <select name="departamento" id="dep">
                        <option value="1">RH</option>
                        <option value="2">Ventas</option>
                        <option value="3">Gerencia</option>
                        <option value="4">Almacen</option>
                    </select>
                    <label for="dep">Departamento</label>
                </div>


                <input type="submit" name="mod" value="Modificar">
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
                $nombre = trim($_POST['nombre']);
                $apep = trim($_POST['apep']);
                $apem = trim($_POST['apem']);
                $fecha = trim($_POST['fecha']);
                $turno = trim($_POST['turno']);
                $telefono = trim($_POST['telefono']);
                $direccion = trim($_POST['direccion']);
                $correo = trim($_POST['correo']);
                $departamento = trim($_POST['departamento']);

                $query = "INSERT INTO `empleado`(`nombre`, `apep`, `apem`, `fecha_ingreso`, `turno`, `telefono`, `direccion`, `correo`, `FK_depa`) VALUES ('$nombre','$apep','$apem','$fecha','$turno','$telefono','$direccion','$correo','$departamento')";
                mysqli_query($conn, $query) or die("error en la consulta");
            }

            if (isset($_POST['modificar'])) {
                echo "<script type = 'text/javascript'>
                            document.getElementById('modify').classList.remove('hidden');
                            </script>";

                session_reset();
                $_SESSION['id'] = $_POST['id'];
            }

            if (isset($_POST['mod'])) {

                $id = $_SESSION['id'];

                $nombre = trim($_POST['nombre']);
                $apep = trim($_POST['apep']);
                $apem = trim($_POST['apem']);
                $fecha = trim($_POST['fecha']);
                $turno = trim($_POST['turno']);
                $telefono = trim($_POST['telefono']);
                $direccion = trim($_POST['direccion']);
                $correo = trim($_POST['correo']);
                $departamento = trim($_POST['departamento']);


                $query = "UPDATE `empleado` SET `nombre`='$nombre',`apep`='$apep',`apem`='$apem',`fecha_ingreso`='$fecha',`turno`='$turno',`telefono`='$telefono',`direccion`='$direccion',`correo`='$correo',`FK_depa`='$departamento' WHERE `PK_matricula`='$id'";
                mysqli_query($conn, $query) or die("ERROR");
            }

            if (isset($_POST['borrar'])) {
                $id = $_POST['id'];
                $query = "DELETE FROM `empleado` WHERE `PK_matricula`='$id'";
                mysqli_query($conn, $query);
            }
            mysqli_close($conn);
            ?>

        </div>
    </div>
</body>

</html>