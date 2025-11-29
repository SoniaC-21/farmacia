<?php
    session_start();

    if (!isset($_SESSION['id_cliente'])) {
        header("Location: clientes.php");
        exit();
    }

    $nombre = $_SESSION['nombre_cliente'];
    $id_cliente = $_SESSION['id_cliente'];

    include "../modelo/conexion.php";
    $db = conecta();

    $sql = "SELECT * FROM venta WHERE id_cliente = :id_cliente ORDER BY fecha_venta DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia - Panel</title>
    <link rel="stylesheet" href="estilos_cliente.css">
</head>
<body>

    <div class="sidebar">
        <h2 class="logo">Farmacia</h2>
        <a href="panelInicioCliente.php">Inicio</a>
        <a href="catalogoCliente.php">Catálogo</a>
        <a href="clientes.php">Cerrar sesión</a>
    </div>

    <div class="content">
        <h1>Bienvenido</h1>
        <h2><?php echo $nombre; ?> </h2>

        <h2>Historial de Compras</h2>

        <table class="tabla-historial">
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Detalles</th>
            </tr>

            <?php if (count($historial) > 0): ?>
                <?php foreach ($historial as $venta): ?>
                    <tr>
                        <td><?php echo $venta['id_venta']; ?></td>
                        <td><?php echo $venta['fecha_venta']; ?></td>
                        <td>$<?php echo number_format($venta['total_venta'], 2); ?></td>
                        <td>
                            <button class="btn-detalles" onclick="toggleDetalles(<?php echo $venta['id_venta']; ?>)">
                                Ver detalles
                            </button>
                        </td>
                    </tr>

                    <tr id="detalles-<?php echo $venta['id_venta']; ?>" style="display:none;">
                        <td colspan="4">

                            <?php
                                $sql_det = "
                                    SELECT p.nombre_producto, dv.cantidad, dv.precio_venta_producto
                                    FROM detalles_venta dv
                                    INNER JOIN producto p ON dv.id_producto = p.id_producto
                                    WHERE dv.id_venta = :id_venta
                                ";
                                $stmt_det = $db->prepare($sql_det);
                                $stmt_det->bindParam(':id_venta', $venta['id_venta']);
                                $stmt_det->execute();
                                $detalles = $stmt_det->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <table class="tabla-detalles">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>

                                <?php foreach ($detalles as $d): ?>
                                    <tr>
                                        <td><?php echo $d['nombre_producto']; ?></td>
                                        <td><?php echo $d['cantidad']; ?></td>
                                        <td>$<?php echo number_format($d['precio_venta_producto'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>

                        </td>
                    </tr>


                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        No tienes compras registradas.
                    </td>
                </tr>
            <?php endif; ?>

        </table>

        
    </div>

    <script>
        function toggleDetalles(id) {
            let fila = document.getElementById("detalles-" + id);
            fila.style.display = fila.style.display === "none" ? "table-row" : "none";
        }
    </script>

</body>
</html>
