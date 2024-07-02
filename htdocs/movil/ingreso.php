<?php
    include "bd.php";
    
    function ingreso($usr, $pass)
    {
        $bd = mysqli_connect('localhost', 'root', '', 'bd_movil');
        $sql = "SELECT * FROM cuenta WHERE usuario='$usr' and pass='$pass'";
        $res = mysqli_query($bd, $sql) or die("FAILED");

        if ($res->num_rows >0) {
            foreach ($res as $dato) return $dato['id'];
        }
        return -1;
    }

    if(isset($_GET['usr']) && isset($_GET['pass'])){
        $usr = $_GET['usr'];
        $pass = $_GET['pass'];

        $res = ingreso($usr,$pass);

        echo '{"usr":'.$res.'}';
    }    
?>