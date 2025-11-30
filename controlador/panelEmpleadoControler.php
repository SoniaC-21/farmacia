<?php

include "../modelo/empleadoModel.php";

session_start();

// Verificar si hay sesión de empleado
if (!isset($_SESSION['empleado_id'])) {
    header("Location: ../vista/inicio.php");
    exit();
}

$model = new EmpleadoModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAgregarProducto'])) {

    $data = [
        'nombre'       => $_POST['nombre_producto'],
        'presentacion' => $_POST['presentacion'],
        'precio'       => $_POST['precio'],
        'cantidad'     => $_POST['cantidad'],
        'caducidad'    => $_POST['fecha_caducidad'],
        'proveedor'    => $_POST['id_proveedor'],
        'receta'       => isset($_POST['requiere_receta']) ? 1 : 0
    ];

    $ok = $empleadoModel->agregarProductoConCompra($data);

    if ($ok) {
        echo "<script>alert('Producto y compra registrados correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar compra/producto');</script>";
    }
}



// Manejar acciones AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    header('Content-Type: application/json');
    
    $accion = $_POST['accion'];
    
    switch ($accion) {
        case 'obtener_productos':
            $producto = $model->obtenerProductos();
            echo json_encode(['success' => true, 'data' => $producto]);
            exit();
            
        case 'agregar_producto':

            $nombre = $_POST['nombre'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $cantidad = $_POST['cantidad'] ?? 0;
            $presentacion = $_POST['presentacion'] ?? '';
            $fecha_caducidad = $_POST['fecha_caducidad'] ?? null;
            $id_proveedor = $_POST['id_proveedor'] ?? null;
            $necesita_receta = isset($_POST['necesita_receta']) ? 1 : 0;

            if (empty($nombre) || $precio <= 0 || $cantidad <= 0) {
                echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
                exit();
            }

            if (empty($id_proveedor) || $id_proveedor <= 0) {
                echo json_encode(['success' => false, 'message' => 'Debe seleccionar un proveedor']);
                exit();
            }

            try {

                // 1️⃣ Registrar producto
                $id_producto = $model->agregarProducto(
                    $nombre,
                    $precio,
                    $cantidad,
                    $presentacion,
                    $fecha_caducidad,
                    $id_proveedor,
                    $necesita_receta
                );

                if (!$id_producto) {
                    echo json_encode(['success' => false, 'message' => 'Error al registrar producto']);
                    exit();
                }

                // 2️⃣ Registrar compra automática
                $total_compra = $precio * $cantidad;
                $id_compra = $model->registrarCompraProveedor($id_proveedor, $total_compra);

                // 3️⃣ Registrar detalle de compra
                $model->registrarDetalleCompra(
                    $id_compra,
                    $id_producto,
                    $cantidad,
                    $precio
                );

                echo json_encode([
                    'success' => true,
                    'message' => 'Producto y compra registrados correctamente'
                ]);
                exit();

            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit();
            }


            
        case 'eliminar_producto':
            $id = $_POST['id'] ?? 0;
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                exit();
            }
            
            $resultado = $model->eliminarProducto($id);
            echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Producto eliminado correctamente' : 'Error al eliminar producto']);
            exit();
            
        case 'actualizar_stock':
            $id = $_POST['id'] ?? 0;
            $cantidad = $_POST['stock'] ?? 0;
            
            if ($id <= 0 || $cantidad < 0) {
                echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
                exit();
            }
            
            $resultado = $model->actualizarStock($id, $cantidad);
            echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Cantidad actualizada correctamente' : 'Error al actualizar cantidad']);
            exit();
            
        case 'obtener_compras':
            $compras = $model->obtenerCompras();
            echo json_encode(['success' => true, 'data' => $compras]);
            exit();
            
        case 'obtener_detalle_compra':
            $id_compra = $_POST['id_compra'] ?? 0;
            if ($id_compra <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                exit();
            }
            
            $detalles = $model->obtenerDetalleCompra($id_compra);
            echo json_encode(['success' => true, 'data' => $detalles]);
            exit();
            
        case 'buscar_producto':
            $nombre = $_POST['nombre'] ?? '';
            $producto = $model->buscarProducto($nombre);
            echo json_encode(['success' => true, 'data' => $producto]);
            exit();

        case 'registrar_compra':
                $total = $_POST['total'] ?? 0;
                $detalles = json_decode($_POST['detalles'], true);
            
                if ($total <= 0 || empty($detalles)) {
                    echo json_encode(['success' => false, 'message' => 'Compra inválida']);
                    exit();
                }
            
                // Registrar encabezado de compra
                $id_compra = $model->registrarCompra($total);
            
                foreach ($detalles as $det) {
                    $model->insertarDetalleCompra(
                        $id_compra,
                        $det['id_producto'],
                        $det['cantidad'],
                        $det['precio']
                    );
            
                    // Actualizar stock
                    $model->actualizarStock($det['id_producto'], $det['nuevo_stock']);
                }
            
                echo json_encode(['success' => true, 'message' => 'Compra registrada correctamente']);
                exit();
            
            
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            exit();
    }
}

?>

