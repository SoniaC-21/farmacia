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

    case 'obtener_clientes':
        $clientes = $model->obtenerClientes();
        echo json_encode(["success" => true, "data" => $clientes]);
        break;

    case 'registrar_venta_completa':
        $idCliente = $_POST['id_cliente'] ?? 0;
        $productos = json_decode($_POST['productos'], true) ?? [];

        if ($idCliente <= 0) {
            echo json_encode(["success" => false, "message" => "Debe seleccionar un cliente"]);
            exit();
        }

        if (empty($productos)) {
            echo json_encode(["success" => false, "message" => "Debe agregar al menos un producto"]);
            exit();
        }

        $idEmpleado = $_SESSION['empleado_id'];
        $resultado = $model->registrarVentaCompleta($idEmpleado, $idCliente, $productos);
        echo json_encode($resultado);
        break;

                $fecha = $_POST['fecha_compra'] ?? '';
                $proveedor = $_POST['id_proveedor'] ?? 0;
                $total = $_POST['total_compra'] ?? 0;
            
                // Validaciones
                if (empty($fecha)) {
                    echo json_encode(['success' => false, 'message' => 'Debe ingresar la fecha de compra']);
                    exit();
                }
            
                if ($proveedor <= 0) {
                    echo json_encode(['success' => false, 'message' => 'Debe seleccionar un proveedor válido']);
                    exit();
                }
            
                if ($total <= 0) {
                    echo json_encode(['success' => false, 'message' => 'El total debe ser mayor a 0']);
                    exit();
                }
            
                // Llamar al modelo
                $resultado = $model->agregarCompra($fecha, $proveedor, $total);
            
                echo json_encode([
                    'success' => $resultado, 
                    'message' => $resultado ? 'Compra registrada correctamente' : 'Error al registrar compra'
                ]);
                exit();
            
    case 'obtener_proveedores':
        $proveedores = $model->obtenerProveedores();
        echo json_encode(['success' => true, 'data' => $proveedores]);
        exit();

    case 'buscar_proveedor':
        $nombre = $_POST['nombre'] ?? '';
        $proveedores = $model->buscarProveedor($nombre);
        echo json_encode(['success' => true, 'data' => $proveedores]);
        exit();

    case 'agregar_proveedor':
        $nombre    = $_POST['nombre']    ?? '';
        $telefono  = $_POST['telefono']  ?? '';
        $email     = $_POST['email']     ?? '';
        $direccion = $_POST['direccion'] ?? '';

        if (empty($nombre)) {
            echo json_encode(['success' => false, 'message' => 'El nombre del proveedor es obligatorio']);
            exit();
        }

        $resultado = $model->agregarProveedor($nombre, $telefono, $email, $direccion);

        echo json_encode([
            'success' => $resultado,
            'message' => $resultado ? 'Proveedor agregado correctamente' : 'Error al agregar proveedor'
        ]);
        exit();
    
    case 'obtener_proveedor':
        $id = intval($_POST['id_proveedor'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit();
        }
        $proveedor = $model->obtenerProveedorPorId($id);
        echo json_encode(['success' => $proveedor ? true : false, 'data' => $proveedor]);
        exit();

    case 'actualizar_proveedor':
        $id        = intval($_POST['id_proveedor'] ?? 0);
        $nombre    = $_POST['nombre']    ?? '';
        $telefono  = $_POST['telefono']  ?? '';
        $email     = $_POST['email']     ?? '';
        $direccion = $_POST['direccion'] ?? '';

        if ($id <= 0 || empty($nombre)) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit();
        }

        $resultado = $model->actualizarProveedor($id, $nombre, $telefono, $email, $direccion);
        echo json_encode(['success' => $resultado]);
        exit();

    case 'eliminar_proveedor':
        $id = intval($_POST['id_proveedor'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit();
        }
        $resultado = $model->eliminarProveedor($id);
        echo json_encode(['success' => $resultado]);
        exit();
                
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        exit();
}


