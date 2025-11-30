<?php
    session_start();

    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../vista/admin.php");
        exit();
    }

    include "../modelo/administracion_empleadoModel.php";

    $model = new AdministracionEmpleadoModel();
    $mensaje = "";

    // Si viene petición de eliminación por GET
    if (isset($_GET['eliminar'])) {
        $idEliminar = (int) $_GET['eliminar'];

        if ($idEliminar > 0) {
            $model->eliminarEmpleado($idEliminar);
            //$mensaje = "Empleado eliminado correctamente.";
        }
    }

    // Si viene un POST del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_empleado'])) {

        $nombre   = $_POST['nombre_empleado'];
        $telefono = $_POST['telefono_empleado'];
        $email    = $_POST['email_empleado'];
        $password = $_POST['password'];
        $fecha_contratacion = $_POST['fecha_contratacion'] ?? date('Y-m-d');
        $id_admin = $_SESSION['id_admin'];

        if ($nombre !== '' && $email !== '' && $password !== '') {
            try {
                $ok = $model->registrarEmpleado(
                    $nombre,
                    $telefono,
                    $email,
                    $password,
                    $fecha_contratacion,
                    $id_admin
                );

                if ($ok) {
                    $mensaje = "Empleado registrado correctamente.";
                } else {
                    $mensaje = "No se pudo registrar el empleado.";
                }
            } catch (Exception $e) {
                $mensaje = "Error: " . $e->getMessage();
            }
        } else {
            $mensaje = "Faltan campos obligatorios (nombre, email o contraseña).";
        }
    }

    //lista de empleados para mostrarla en la vista
    $empleados = $model->obtenerEmpleados();

    include "../vista/panel_admin.php";
?>