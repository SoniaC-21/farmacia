<?php

        include "../modelo/homeModel.php";

if (isset($_POST['registro'])) {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    $model = new HomeModel();

    if ($model->registrarUsuario($nombre, $email, $telefono, $password)) {
        header("Location: /farmacia/vista/clientes.php");
        exit();

    } else {
        echo "<h2>Error al registrar</h2>";
    }
}

?>