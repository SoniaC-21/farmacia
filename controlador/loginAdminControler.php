<?php
    session_start();

    include "../modelo/adminModel.php";

    if (isset($_POST['login'])) {


        $email = $_POST['email'];
        $password = $_POST['password'];

        $model = new HomeModel();

        $usuario = $model->validarLogin($email, $password);

        if ($usuario) {
            //guarda el id_admin en la sesion
            $_SESSION['id_admin'] = $usuario['id_admin'];
            //header("Location: ../vista/panel_admin.php");
            header("Location: ../controlador/administrar_empleado.php");
            exit();
        } else {
            //echo "<h2>Usuario o contraseña incorrectos</h2>";
            //echo "<a href='../vista/admin.php'>Intentar nuevamente</a>";
            // Guardamos mensaje de error en la sesión
        $_SESSION['login_error'] = "Usuario o contraseña incorrectos";

        // Volvemos al formulario de login
        header("Location: ../vista/admin.php");
        exit();
        }
    }

?>