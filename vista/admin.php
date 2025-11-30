<?php
    session_start();
    $login_error = $_SESSION['login_error'] ?? '';
    // Limpiamos el mensaje para que no se quede pegado
    unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Iniciar Sesión</h1>
    
    <?php if (!empty($login_error)): ?>
        <div class="alerta-error">
            <?php echo htmlspecialchars($login_error); ?>
        </div>
    <?php endif; ?>

    <form action="../controlador/loginAdminControler.php" method="POST">

        <label>Correo electrónico:</label>
        <input type="email" name="email" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Entrar</button>
    </form>

</div>

</body>
</html>