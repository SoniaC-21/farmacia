<?php
        include "../controlador/homeControler.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../estilos_C.css">
</head>
<body>

<div class="contenedor">
    <h1>Iniciar Sesión</h1>

    <form action="../controlador/loginControler.php" method="POST">

        <label>Correo electrónico:</label>
        <input type="email" name="email" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Entrar</button>
    </form>

    <div class="enlace">
        <a href="registro.php">¿No tienes cuenta? Regístrate</a><br>
        <br><a href="../">Volver a inicio</a>
    </div>
</div>

</body>
</html>