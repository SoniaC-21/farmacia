<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Empleado</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Registrar Empleado</h1>

    <form action="../controlador/reg_empleado.php" method="POST">

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

        <!-- Este campo puede ser hidden si el admin ya inició sesión -->
        <label>ID del Administrador:</label>
        <input type="number" name="id_admin" required>

        <button type="submit" name="registrar_empleado">Registrar Empleado</button>
    </form>

    <div class="enlace">
        <a href="./empleados.php">Volver</a>
    </div>

</div>

</body>
</html>
