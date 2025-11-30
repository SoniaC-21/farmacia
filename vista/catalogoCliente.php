<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header("Location: clientes.php");
    exit();
}

include "../modelo/conexion.php";
$db = conecta();

$sql = "SELECT * FROM producto";
$stmt = $db->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="estilos_cliente.css">

</head>
<body>

    <div class="sidebar">
        <h2 class="logo">Farmacia</h2>
        <a href="panelInicioCliente.php">Inicio</a>
        <a href="catalogoCliente.php">Catálogo</a>
        <a href="clientes.php">Cerrar sesión</a>
    </div>

    <div class="tabla-productos">
        <h1>Catálogo de Productos</h1>
        <p>Estos son los productos disponibles en la farmacia:</p>

        <table>
            <tr>
                <th>Producto</th>
                <th>Presentación</th>
                <th>Precio</th>
                <th>Existencia</th>
                <th>Caducidad</th>
                <th>Requiere Receta</th>
            </tr>

            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?php echo $p['nombre_producto']; ?></td>
                    <td><?php echo $p['presentacion_producto']; ?></td>
                    <td>$<?php echo number_format($p['precio_producto'], 2); ?></td>
                    <td><?php echo $p['cantidad_existente']; ?></td>
                    <td><?php echo $p['fecha_caducidad']; ?></td>
                    <td>
                        <?php 
                            if ($p['necesita_receta'] == 1) {
                                echo "<span class='receta'>Sí</span>";
                            } else {
                                echo "No";
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>

</body>
</html>
