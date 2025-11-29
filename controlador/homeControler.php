<?php

        include "../modelo/homeModel.php";

$model = new HomeModel();

if (isset($_POST['registro'])) {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    if ($model->emailExiste($email)) {
        echo "<h2 style='color:red;'>El correo <b>$email</b> ya está registrado.</h2>";
        echo "<a href='../vista/registro.php'>Regresar al registro</a>";
        exit();
    }

    if ($model->registrarUsuario($nombre, $email, $telefono, $password)) {
        header("Location: /farmacia/vista/clientes.php");
        exit();

    } else {
        echo "<h2>Error al registrar</h2>";
    }
}

?>