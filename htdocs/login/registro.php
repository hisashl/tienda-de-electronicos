<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="logbox">
        <h1>Nueva cuenta</h1>
        <form action="" method="post">
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
            <div class="txt_field">
                <input type="password" name="contra2" required>
                <span></span>
                <label>Confirma la contraseña</label>
            </div>
            <div class="txt_field">
                <input type="text" name="email" required>
                <span></span>
                <label>Ingresa tu correo</label>
            </div>
            <div id="hide" class="hidden error">Las contrasenas no coinciden</div>
            <input type="submit" name="ingreso" value="Crear cuenta" style="margin:0 30px 0 0">
            <div class="signup_link">
                Ya tiene cuenta? <a href="index.php">Ingresa</a>
            </div>
        </form>
    </div>

    <?php
    include 'bd.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['ingreso'])) {
            $usuario = trim($_POST['usuario']);
            $contra = $_POST['contra'];
            $contra2 = $_POST['contra2'];
            $encriptado = MD5($contra);
            $email = trim($_POST['email']);

            if ($contra === $contra2) {
                $query = "INSERT INTO registro(usuario, contra, tipo, email) VALUES ('$usuario','$encriptado', '1', '$email')" or die("Problema con el registro");
                $result = mysqli_query($conn, $query) or die("Error al hacer la consulta");
                header('Location: index.php');
            } else {

                echo "<script type = 'text/javascript'>
                document.getElementById('hide').classList.remove('hidden');
                </script>";
            }
        }
    }

    mysqli_close($conn);
    ?>
</body>

</html>