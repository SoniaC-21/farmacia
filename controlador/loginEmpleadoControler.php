<?php

include "../modelo/empleadoModel.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $model = new HomeModel();

    $usuario = $model->validarLogin($email, $password);

    if ($usuario) {
        // Login exitoso → redirige a dashboard, inicio, etc.
        header("Location: ../vista/panel.php");
        exit();
    } else {
        echo "<h2>Usuario o contraseña incorrectos</h2>";
        echo "<a href='../vista/home.php'>Intentar nuevamente</a>";
    }
}

?>