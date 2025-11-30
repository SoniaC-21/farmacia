<?php

include "../modelo/empleadoModel.php";

session_start();

// Verificar si hay sesión de empleado
if (!isset($_SESSION['empleado_id'])) {
    header("Location: ../vista/inicio.php");
    exit();
}

$model = new EmpleadoModel();

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
            
            if (empty($nombre) || $precio <= 0) {
                echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
                exit();
            }
            
            // Si fecha_caducidad está vacía, establecer como null
            if (empty($fecha_caducidad)) {
                $fecha_caducidad = null;
            }
            
            // Si id_proveedor está vacío, establecer como null
            if (empty($id_proveedor) || $id_proveedor <= 0) {
                echo json_encode(['success' => false, 'message' => 'Debe seleccionar un proveedor válido']);
                exit();
            }
            
            
            $resultado = $model->agregarProducto($nombre, $precio, $cantidad, $presentacion, $fecha_caducidad, $id_proveedor, $necesita_receta);
            echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Producto agregado correctamente' : 'Error al agregar producto']);
            exit();
            
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

