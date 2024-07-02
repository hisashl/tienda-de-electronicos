<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cliente.css">
    <title>Clientes</title>
    <script src="https://kit.fontawesome.com/fa5913e7cf.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'bd.php';
    session_start();
    $email = $_SESSION['email'];
    $query = "SELECT * FROM cliente WHERE correo='$email'";
    $res = mysqli_query($conn, $query);

    if ($res->num_rows > 0) {
        $data = mysqli_fetch_assoc($res);
        echo $data['nombre'] . $data['apep'] . $data['apem'] . $data['telefono'];
    } else {
        echo 'No se encontraron usuarios';
    }
    ?>
</body>

</html>