<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Registro</h1>

    <form action="../controlador/homeControler.php" method="POST">

        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Correo electrónico:</label>
        <input type="email" name="email" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono">

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit" name="registro">Registrarse</button>
    </form>

    <div class="enlace">
        <a href="./clientes.php">¿Ya tienes cuenta? Inicia sesión</a>
    </div>

</div>

</body>                                                                                        
</html> 