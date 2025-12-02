<?php

include "../modelo/empleadoModel.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $model = new EmpleadoModel();

    $usuario = $model->validarLogin($email, $password);

    if ($usuario) {
        // Iniciar sesión
        session_start();
        $_SESSION['empleado_id'] = $usuario['id_empleado'];
        $_SESSION['empleado_nombre'] = $usuario['nombre_empleado'] ?? 'Empleado';
        // Login exitoso → redirige a dashboard
        header("Location: ../vista/panelEmpleado.php");
        exit();
    } else {
        echo "<h2>Usuario o contraseña incorrectos</h2>";
        echo "<a href='../vista/empleados.php'>Intentar nuevamente</a>";
    }
}

?>