<?php

session_start();

include "../modelo/homeModel.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $model = new HomeModel();

    $usuario = $model->validarLogin($email, $password);

    if ($usuario) {
        
        $_SESSION['id_cliente'] = $usuario['id_cliente'];
        $_SESSION['nombre_cliente'] = $usuario['nombre_cliente'];
        $_SESSION['email_cliente'] = $usuario['email_cliente'];

        header("Location: ../vista/panelInicioCliente.php");
        exit();

    } else {
        echo "<h2>Usuario o contraseña incorrectos</h2>";
        echo "<a href='../vista/clientes.php'>Intentar nuevamente</a>";
    }
}

?>