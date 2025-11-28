<?php

        include "../modelo/reg_empleadoModelo.php";

if (isset($_POST['registro'])) {

    $nombre_empleado = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono_empleado = $_POST['telefono'];
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