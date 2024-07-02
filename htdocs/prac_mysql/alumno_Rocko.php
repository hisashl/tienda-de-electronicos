<?php
    if(isset($_POST['enviar'])){
        if( strlen($_POST['reg'])>=1 &&
        ((strlen($_POST['nombre']))>=1 && (strlen($_POST['nombre']))<31) &&
        ((strlen($_POST['apep']))>=1 && (strlen($_POST['apep']))<31) && 
        ((strlen($_POST['apem']))>=1 && (strlen($_POST['apem']))<31) &&
        ((strlen($_POST['tel'])) >= 1 && (strlen($_POST['tel'])) < 11) &&
        ((strlen($_POST['domicilio'])) >= 1 && (strlen($_POST['domicilio'])) < 56) &&
        (strlen($_POST['mun']) >= 1) &&
        (strlen($_POST['carrera']) >= 1) ){

            $registro = trim($_POST['reg']);
            $nombre = trim($_POST['nombre']);
            $apep = trim($_POST['apep']);
            $apem = trim($_POST['apem']);
            $telefono = trim($_POST['tel']);
            $domicilio = trim($_POST['domicilio']);
            $municipio = $_POST['mun'];
            $carrera = $_POST['carrera'];

            $con = mysqli_connect("localhost", "root", "") or die("Error: No se ha podido conectar al servidor");
            $db = mysqli_select_db($con, "bd_ceti_6f") or die("Error: No se ha podido conectar a la base de datos");

            $query_mun = mysqli_query($con, "SELECT PK_Municipio FROM municipio WHERE Nombre='$municipio'");
            $query_car = mysqli_query($con, "SELECT PK_Carrera FROM carrera WHERE Nombre='$carrera'");

            while ($columna = mysqli_fetch_array($query_mun)) {
                $pk_mun = $columna['PK_Municipio'];
                
            }

            while ($columna = mysqli_fetch_array($query_car)) {
                $pk_car = $columna['PK_Carrera'];
                
            }
            
            $query = "INSERT INTO `alumno`(`Registro`, `Nombre`, `ApeP`, `ApeM`, `Celular`, `Domicilio`, `FK_Municipio`, `FK_Carrera`)
             VALUES ('$registro','$nombre','$apep','$apem','$telefono','$domicilio','$pk_mun','$pk_car')";
            $resultado = mysqli_query($con, $query) or die("Error: No se ha podido realizar la consulta");
            ;
            if($resultado){
                echo "<h1>Datos del alumno agregado:</h1><br/>";
                echo "<p>Registro: $registro</p><br/>";
                echo "<p>Nombre: $nombre</p><br/>";
                echo "<p>Apellido Paterno: $apep</p><br/>";
                echo "<p>Apellido Materno: $apem</p><br/>";
                echo "<p>Telefono: $telefono</p><br/>";
                echo "<p>Domicilio: $domicilio</p><br/>";
                echo "<p>Municipio: $municipio</p><br/>";
                echo "<p>Carrera: $carrera</p>";
            }
            
        }else{
            print("<h3>Datos faltantes o invalidos</h3>");
        }
    }
?>