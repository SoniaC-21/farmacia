<?php
    include_once "../modelo/administracion_empleadoModel.php";
    $model = new AdministracionEmpleadoModel();
    $empleados = $model->obtenerEmpleados();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administracion</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="body-panel">

<div class="contenedor-panel">

    <!-- ====== FORMULARIO REGISTRO EMPLEADO ====== -->
    <div class="contenedor formulario-empleado">
        <h1>Registrar Empleado</h1>

        <?php if (!empty($mensaje)) : ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <form action="../controlador/administrar_empleado.php" method="POST">

            <label>Nombre del empleado:</label>
            <input type="text" name="nombre_empleado" required>

            <label>Teléfono del empleado:</label>
            <input type="text" name="telefono_empleado" maxlength="16">

            <label>Correo electrónico:</label>
            <input type="email" name="email_empleado" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <label>Fecha de contratación:</label>
            <input type="date" name="fecha_contratacion" required>

            <button type="submit" name="registrar_empleado">Registrar Empleado</button>
            
        </form>
        <div class="enlace">
            <br><a href="../vista/admin.php">Salir</a>
        </div>


         <div class="enlace">
            <a href="../vista/admin.php">Volver a inicio</a>
        </div>
    </div>

   

    <!-- ====== LISTADO DE EMPLEADOS ====== -->
    <div class="contenedor lista-empleados">
        <h1>Empleados registrados</h1>

        <?php if (!empty($empleados)) : ?>
            <div class="tabla-wrapper">
                <table class="tabla-empleados">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Fecha contratación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($empleados as $emp) : ?>
                            <tr>
                                <td>
                                    <a 
                                        href="../controlador/administrar_empleado.php?eliminar=<?php echo $emp['id_empleado']; ?>" 
                                        class="btn-eliminar"
                                        onclick="return confirm('¿Seguro que quieres eliminar al empleado <?php echo htmlspecialchars($emp['nombre_empleado']); ?>?');"
                                    >
                                        Eliminar
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($emp['id_empleado']); ?></td>
                                <td><?php echo htmlspecialchars($emp['nombre_empleado']); ?></td>
                                <td><?php echo htmlspecialchars($emp['telefono_empleado']); ?></td>
                                <td><?php echo htmlspecialchars($emp['email_empleado']); ?></td>
                                <td><?php echo htmlspecialchars($emp['fecha_contratacion']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>No hay empleados registrados todavía.</p>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
