<?php

include "conexion.php";

class EmpleadoModel {

    private $db;

    public function __construct() {
        $this->db = conecta();
    }

    public function validarLogin($email, $password) {
        $sql = "SELECT * FROM empleado WHERE email_empleado = :email AND  `password` = :password";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los producto del inventario
    public function obtenerProductos() {
        $sql = "SELECT * FROM producto ORDER BY nombre_producto ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar nuevo producto
    public function agregarProducto($nombre, $precio, $cantidad, $presentacion, $id_proveedor, $necesita_receta) {

        $sql = "INSERT INTO producto 
                (nombre_producto, precio_producto, cantidad_existente, presentacion_producto,
                id_proveedor, necesita_receta)
                VALUES (:nombre, :precio, :cantidad, :presentacion, 
                        :id_proveedor, :necesita_receta)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':presentacion', $presentacion);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->bindParam(':necesita_receta', $necesita_receta);

        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // ID REAL
        }

        return false;
    }

    public function registrarCompraProveedor($id_proveedor, $total)
    {
        $sql = "INSERT INTO compra_producto (fecha_compra, id_proveedor, total_compra)
                VALUES (NOW(), :id_proveedor, :total)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->bindParam(':total', $total);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function registrarDetalleCompra($id_compra, $id_producto, $cantidad, $precio)
    {
        $sql = "INSERT INTO detalles_compra
                (id_compra, id_producto, cantidad, precio_compra_producto)
                VALUES (:id_compra, :id_producto, :cantidad, :precio)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_compra', $id_compra);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precio', $precio);
        return $stmt->execute();
    }

    public function agregarProductoConCompra($data) {
        try {
            // -------------- INICIAR TRANSACCIÓN --------------------
            $this->db->beginTransaction();

            // -------------- 1) INSERTAR PRODUCTO --------------------
            $sqlProducto = "INSERT INTO producto 
                (nombre_producto, presentacion_producto, precio_producto, cantidad_existente, 
                id_proveedor, necesita_receta)
                VALUES (:nombre, :presentacion, :precio, :cantidad, :proveedor, :receta)";

            $stmt = $this->db->prepare($sqlProducto);
            $stmt->execute([
                ':nombre'       => $data['nombre'],
                ':presentacion' => $data['presentacion'],
                ':precio'       => $data['precio'],
                ':cantidad'     => $data['cantidad'],
                ':proveedor'    => $data['proveedor'],
                ':receta'       => $data['receta']
            ]);

            $id_producto = $this->db->lastInsertId();

            // -------------- 2) INSERTAR COMPRA --------------------
            $total_compra = $data['precio'] * $data['cantidad'];

            $sqlCompra = "INSERT INTO compra (fecha_compra, total_compra)
                        VALUES (NOW(), :total)";

            $stmt = $this->db->prepare($sqlCompra);
            $stmt->execute([':total' => $total_compra]);

            $id_compra = $this->db->lastInsertId();

            // -------------- 3) INSERTAR DETALLE --------------------
            $sqlDetalle = "INSERT INTO detalle_compra 
                        (id_compra, id_producto, cantidad, precio_compra_producto)
                        VALUES (:compra, :producto, :cantidad, :precio)";

            $stmt = $this->db->prepare($sqlDetalle);
            $stmt->execute([
                ':compra'   => $id_compra,
                ':producto' => $id_producto,
                ':cantidad' => $data['cantidad'],
                ':precio'   => $data['precio']
            ]);
            
            // -------------- CONFIRMAR --------------------
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Eliminar producto respetando restricciones de clave foránea
    public function eliminarProducto($id) {
        try {
            $sql = "DELETE FROM producto WHERE id_producto = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Si no lanzó excepción, se eliminó bien
            return [
                'ok'      => true,
                'message' => 'Producto eliminado correctamente'
            ];

        } catch (PDOException $e) {
            // 23000 = violación de integridad (claves foráneas, unique, etc.)
            if ($e->getCode() === '23000') {
                return [
                    'ok'      => false,
                    'message' => 'No se puede eliminar el producto porque está asociado a compras o ventas registradas.'
                ];
            }

            // Otro error de BD
            return [
                'ok'      => false,
                'message' => 'Error en la base de datos al eliminar el producto.'
            ];
        }
    }

    // Actualizar cantidad existente de producto
    public function actualizarStock($id, $cantidad) {
        $sql = "UPDATE producto SET cantidad_existente = :cantidad WHERE id_producto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function registrarCompra($total) {
        $sql = "INSERT INTO compra (fecha_compra, total_compra) 
                VALUES (NOW(), :total)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total', $total);
        $stmt->execute();
        return $this->db->lastInsertId(); 
    }
    
    public function insertarDetalleCompra($id_compra, $id_producto, $cantidad, $precio) {
        $sql = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio_compra) 
                VALUES (:id_compra, :id_producto, :cantidad, :precio)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_compra', $id_compra);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precio', $precio);
        return $stmt->execute();
    }
    
    // Obtener todas las compras con información de productos
    public function obtenerCompras() {
        $sql = "SELECT c.*, 
                GROUP_CONCAT(DISTINCT p.nombre_producto SEPARATOR ', ') as productos
                FROM compra_producto c
                LEFT JOIN detalles_compra dc ON c.id_compra = dc.id_compra
                LEFT JOIN producto p ON dc.id_producto = p.id_producto
                GROUP BY c.id_compra
                ORDER BY c.fecha_compra DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener detalles de una compra
    public function obtenerDetalleCompra($id_compra) {
        $sql = "SELECT dc.*, p.nombre_producto, p.precio_producto 
                FROM detalles_compra dc 
                INNER JOIN producto p ON dc.id_producto = p.id_producto 
                WHERE dc.id_compra = :id_compra";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_compra', $id_compra);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar producto por nombre
    public function buscarProducto($nombre) {
        $sql = "SELECT * FROM producto WHERE nombre_producto LIKE :nombre ORDER BY nombre_producto ASC";
        $stmt = $this->db->prepare($sql);
        $nombre = "%$nombre%";
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarCompra($fecha_compra, $id_proveedor, $total_compra) {
        $sql = "INSERT INTO compra_producto (fecha_compra, id_proveedor, total_compra) 
                VALUES (:fecha_compra, :id_proveedor, :total_compra)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fecha_compra', $fecha_compra);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->bindParam(':total_compra', $total_compra);
        return $stmt->execute();
    }

    public function obtenerVentas() {
        $sql = "SELECT 
                    v.id_venta,
                    v.fecha_venta,
                    v.id_cliente,
                    v.total_venta
                FROM venta v
                ORDER BY v.fecha_venta DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar nuevo proveedor
    public function agregarProveedor($nombre, $telefono, $email, $direccion) {
        $sql = "INSERT INTO proveedor 
                (nombre_proveedor, telefono_proveedor, email_proveedor, direccion_de_venta)
                VALUES (:nombre, :telefono, :email, :direccion)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        return $stmt->execute();
    }

    // Obtener todos los proveedores
    public function obtenerProveedores() {
        $sql = "SELECT * FROM proveedor ORDER BY nombre_proveedor ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function registrarVenta($idEmpleado, $idCliente, $idProducto, $cantidad)
    {
        try {
            $db = $this->db; 
            $db->beginTransaction();

            // Obtener precio y stock
            $stmt = $db->prepare("SELECT precio_producto, cantidad_existente 
                                FROM producto 
                                WHERE id_producto = ?");
            $stmt->execute([$idProducto]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                return ['success'=>false, 'message'=>'Producto no encontrado'];
            }

            if ($producto['cantidad_existente'] < $cantidad) {
                return ['success'=>false, 'message'=>'No hay suficiente stock'];
            }

            $precio = $producto['precio_producto'];
            $total = $precio * $cantidad;

            // Insertar venta
            $stmt = $db->prepare("INSERT INTO venta 
                (fecha_venta, id_empleado, id_cliente, total_venta)
                VALUES (CURDATE(), ?, ?, ?)");
            $stmt->execute([$idEmpleado, $idCliente, $total]);

            $idVenta = $db->lastInsertId();

            // Insertar detalle venta
            $stmt = $db->prepare("INSERT INTO detalles_venta 
                (id_venta, id_producto, cantidad, precio_venta_producto)
                VALUES (?, ?, ?, ?)");
            $stmt->execute([$idVenta, $idProducto, $cantidad, $precio]);

            // Actualizar stock
            $stmt = $db->prepare("UPDATE producto
                                SET cantidad_existente = cantidad_existente - ?
                                WHERE id_producto = ?");
            $stmt->execute([$cantidad, $idProducto]);

            $db->commit();

            return ['success'=>true];

        } catch (Exception $e) {
            $db->rollBack();
            return ['success'=>false, 'message'=>$e->getMessage()];
        }
    }

    public function obtenerDetalleVenta($idVenta) {
        $sql = "SELECT dv.*, p.nombre_producto
                FROM detalles_venta dv
                INNER JOIN producto p ON dv.id_producto = p.id_producto
                WHERE dv.id_venta = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idVenta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar proveedores por nombre
    public function buscarProveedor($nombre) {
        $sql = "SELECT * 
                FROM proveedor 
                WHERE nombre_proveedor LIKE :nombre
                ORDER BY nombre_proveedor ASC";
        $stmt = $this->db->prepare($sql);
        $nombre = "%$nombre%";
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener lista de clientes
    public function obtenerClientes() {
        $sql = "SELECT id_cliente, nombre_cliente, email_cliente, telefono_cliente 
                FROM cliente 
                ORDER BY nombre_cliente ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar venta con múltiples productos
    public function registrarVentaCompleta($idEmpleado, $idCliente, $productos) {
        try {
            $this->db->beginTransaction();

            // Validar stock y calcular total
            $total = 0;
            $detalles = [];

            foreach ($productos as $producto) {
                $idProducto = $producto['id_producto'];
                $cantidad = (int)$producto['cantidad'];

                // Obtener información del producto
                $stmt = $this->db->prepare("SELECT precio_producto, cantidad_existente, nombre_producto 
                                            FROM producto 
                                            WHERE id_producto = ?");
                $stmt->execute([$idProducto]);
                $prod = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$prod) {
                    throw new Exception("Producto con ID $idProducto no encontrado");
                }

                if ($prod['cantidad_existente'] < $cantidad) {
                    throw new Exception("No hay suficiente stock para {$prod['nombre_producto']}. Stock disponible: {$prod['cantidad_existente']}");
                }

                $precio = $prod['precio_producto'];
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                $detalles[] = [
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'stock_actual' => $prod['cantidad_existente']
                ];
            }

            if ($total <= 0) {
                throw new Exception("El total de la venta debe ser mayor a 0");
            }

            // Insertar venta
            $stmt = $this->db->prepare("INSERT INTO venta 
                (fecha_venta, id_empleado, id_cliente, total_venta)
                VALUES (CURDATE(), ?, ?, ?)");
            $stmt->execute([$idEmpleado, $idCliente, $total]);
            $idVenta = $this->db->lastInsertId();

            // Insertar detalles y actualizar stock
            foreach ($detalles as $detalle) {
                // Insertar detalle de venta
                $stmt = $this->db->prepare("INSERT INTO detalles_venta 
                    (id_venta, id_producto, cantidad, precio_venta_producto)
                    VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $idVenta,
                    $detalle['id_producto'],
                    $detalle['cantidad'],
                    $detalle['precio']
                ]);

                // Actualizar stock
                $nuevoStock = $detalle['stock_actual'] - $detalle['cantidad'];
                $stmt = $this->db->prepare("UPDATE producto 
                                            SET cantidad_existente = ? 
                                            WHERE id_producto = ?");
                $stmt->execute([$nuevoStock, $detalle['id_producto']]);
            }

            $this->db->commit();
            return ['success' => true, 'id_venta' => $idVenta, 'total' => $total];

        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Registrar compra con múltiples productos (pueden ser productos nuevos)
    public function registrarCompraCompleta($idProveedor, $productos) {
        try {
            $this->db->beginTransaction();

            // Validar productos y calcular total
            $total = 0;
            $detalles = [];

            foreach ($productos as $producto) {
                $idProducto = $producto['id_producto'] ?? null;
                $cantidad = (int)$producto['cantidad'];
                $precio = (float)$producto['precio'];
                $nombre = $producto['nombre'] ?? '';
                $presentacion = $producto['presentacion'] ?? null;
                $necesitaReceta = isset($producto['necesita_receta']) ? (int)$producto['necesita_receta'] : 0;

                if (empty($nombre) || $precio <= 0 || $cantidad <= 0) {
                    throw new Exception("Datos inválidos para el producto: $nombre");
                }

                // Si no tiene id_producto, crear nuevo producto
                if (empty($idProducto)) {
                    $idProducto = $this->agregarProducto(
                        $nombre,
                        $precio,
                        $cantidad,
                        $presentacion,
                        $idProveedor,
                        $necesitaReceta
                    );

                    if (!$idProducto) {
                        throw new Exception("Error al crear el producto: $nombre");
                    }
                } else {
                    // Si el producto ya existe, obtener información y actualizar stock
                    $stmt = $this->db->prepare("SELECT precio_producto, cantidad_existente, nombre_producto 
                                                FROM producto 
                                                WHERE id_producto = ?");
                    $stmt->execute([$idProducto]);
                    $prod = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$prod) {
                        throw new Exception("Producto con ID $idProducto no encontrado");
                    }

                    // Actualizar stock (sumar cantidad comprada)
                    $nuevoStock = $prod['cantidad_existente'] + $cantidad;
                    $stmt = $this->db->prepare("UPDATE producto 
                                                SET cantidad_existente = ? 
                                                WHERE id_producto = ?");
                    $stmt->execute([$nuevoStock, $idProducto]);
                }

                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                $detalles[] = [
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad,
                    'precio' => $precio
                ];
            }

            if ($total <= 0) {
                throw new Exception("El total de la compra debe ser mayor a 0");
            }

            // Insertar compra
            $stmt = $this->db->prepare("INSERT INTO compra_producto 
                (fecha_compra, id_proveedor, total_compra)
                VALUES (CURDATE(), ?, ?)");
            $stmt->execute([$idProveedor, $total]);
            $idCompra = $this->db->lastInsertId();

            // Insertar detalles
            foreach ($detalles as $detalle) {
                $stmt = $this->db->prepare("INSERT INTO detalles_compra 
                    (id_compra, id_producto, cantidad, precio_compra_producto)
                    VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $idCompra,
                    $detalle['id_producto'],
                    $detalle['cantidad'],
                    $detalle['precio']
                ]);
            }

            $this->db->commit();
            return ['success' => true, 'id_compra' => $idCompra, 'total' => $total];

        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function obtenerProveedorPorId($id) {
        $sql = "SELECT * FROM proveedor WHERE id_proveedor = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarProveedor($id, $nombre, $telefono, $email, $direccion) {
        $sql = "UPDATE proveedor
                SET nombre_proveedor = :nombre,
                    telefono_proveedor = :telefono,
                    email_proveedor = :email,
                    direccion_de_venta = :direccion
                WHERE id_proveedor = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        return $stmt->execute();
    }

    public function eliminarProveedor($id) {
        try {
            $sql = "DELETE FROM proveedor WHERE id_proveedor = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return [ 'ok' => true ];
        } catch (PDOException $e) {
            // 23000 = violación de llave foránea / integridad
            if ($e->getCode() === '23000') {
                return [
                    'ok' => false,
                    'message' => 'No se puede eliminar el proveedor porque tiene productos o compras asociadas.'
                ];
            }
            return [
                'ok' => false,
                'message' => 'Error en BD: '.$e->getMessage()
            ];
        }
    }

}


?>       