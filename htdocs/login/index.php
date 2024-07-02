<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="logbox">
        <h1>Bienvenido</h1>
        <form method="post">
            <div class="txt_field">
                <input type="text" name="usuario" required>
                <span></span>
                <label>Usuario</label>
            </div>
            <div class="txt_field">
                <input type="password" name="contra" required>
                <span></span>
                <label>Contraseña</label>
            </div>
            <div id="hide" class="hidden error">Usuario o contraseña incorrectos</div>
            <div class="pass">Olvido la contraseña?</div>
            <input type="submit" name="ingreso" value="Login">
            <div class="signup_link">   
                No tiene cuenta? <a href="registro.php">Registrate</a>
            </div>
        </form>
    </div>

    
<?php
    include 'bd.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $usuario = trim($_POST['usuario']);
        $contra = $_POST['contra'];

        $query = "SELECT * FROM `registro` WHERE usuario='$usuario'";
        $result = mysqli_query($conn, $query) or die("Error al hacer la consulta");
        
        if (isset($_POST['ingreso'])) {
            if ($result->num_rows>0) {
                
                session_start();
                

                $row = mysqli_fetch_array($result);
                
                if ($row['usuario'] == $usuario && $row['contra'] == MD5($contra) && $row['tipo'] == '0') {

                    header('Location: empleado/menu.php');
                    
                }else if($row['usuario'] == $usuario && $row['contra'] == MD5($contra) && $row['tipo'] == '1'){

                    $_SESSION['email'] = $row['email'];
                    header('Location: cliente/main.php');
                }else{
                    echo "<script type = 'text/javascript'>
                    document.getElementById('hide').classList.remove('hidden');
                    </script>";
                }
            }
        }
    }
    mysqli_close($conn);
?>


</body>

</html>
