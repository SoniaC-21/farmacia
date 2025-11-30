<?php

include "../modelo/empleadoModel.php";

session_start();

// Verificar sesión
if (!isset($_SESSION['empleado_id'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit();
}

$model = new EmpleadoModel();

// Validar acción
if (!isset($_POST['accion'])) {
    echo json_encode(["success" => false, "message" => "No se especificó acción"]);
    exit();
}

$accion = $_POST['accion'];

switch ($accion) {

    /* ------------------------------
       OBTENER INVENTARIO
    ------------------------------*/
    case 'obtener_productos':
        $productos = $model->obtenerProductos();
        echo json_encode(["success" => true, "data" => $productos]);
        break;


    /* ------------------------------
       BUSCAR PRODUCTO
    ------------------------------*/
    case 'buscar_producto':
        $nombre = $_POST['nombre'] ?? '';
        $productos = $model->buscarProducto($nombre);
        echo json_encode(["success" => true, "data" => $productos]);
        break;


    /* ------------------------------
       ACTUALIZAR STOCK
    ------------------------------*/
    case 'actualizar_stock':
        $id = $_POST['id'];
        $stock = $_POST['stock'];

        $ok = $model->actualizarStock($id, $stock);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Stock actualizado" : "Error al actualizar stock"
        ]);
        break;


    /* ------------------------------
       ELIMINAR PRODUCTO
    ------------------------------*/
    case 'eliminar_producto':
        $id = $_POST['id'];

        $ok = $model->eliminarProducto($id);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Producto eliminado" : "Error al eliminar"
        ]);
        break;


    /* ------------------------------
       AGREGAR PRODUCTO
    ------------------------------*/
    case 'agregar_producto':

        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];

        $presentacion = $_POST['presentacion'] ?? null;
        $fechaCaducidad = $_POST['fecha_caducidad'] ?? null;
        $idProveedor = $_POST['id_proveedor'] ?? null;
        $receta = isset($_POST['necesita_receta']) ? 1 : 0;

        $ok = $model->agregarProducto(
            $nombre,
            $presentacion,
            $precio,
            $cantidad,
            $fechaCaducidad,
            $idProveedor,
            $receta
        );

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Producto agregado" : "Error al agregar producto"
        ]);
        break;


    /* ------------------------------
       OBTENER COMPRAS
    ------------------------------*/
    case 'obtener_compras':
        $compras = $model->obtenerCompras();
        echo json_encode(["success" => true, "data" => $compras]);
        break;


    /* ------------------------------
       OBTENER DETALLE COMPRA
    ------------------------------*/
    case 'obtener_detalle_compra':
        $id = $_POST['id_compra'];

        $detalle = $model->obtenerDetalleCompra($id);
        echo json_encode(["success" => true, "data" => $detalle]);
        break;


    /* ------------------------------
       AGREGAR COMPRA
    ------------------------------*/
    case 'agregar_compra':
        $fecha = $_POST['fecha_compra'];
        $proveedor = $_POST['id_proveedor'];
        $total = $_POST['total_compra'];

        $ok = $model->agregarCompra($fecha, $proveedor, $total);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Compra registrada" : "Error al registrar compra"
        ]);
        break;


    /* ------------------------------
       OBTENER VENTAS
    ------------------------------*/
    case 'obtener_ventas':
        $ventas = $model->obtenerVentas();
        echo json_encode(["success" => true, "data" => $ventas]);
        break;

    case 'obtener_detalle_venta':
        $id = $_POST['id_venta'];
        $detalle = $model->obtenerDetalleVenta($id);
        echo json_encode(["success" => true, "data" => $detalle]);
        break;



    /* ------------------------------
       ACCIÓN DESCONOCIDA
    ------------------------------*/
    default:
        echo json_encode(["success" => false, "message" => "Acción no reconocida"]);
        break;
}

