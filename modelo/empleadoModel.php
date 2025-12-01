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
    public function agregarProducto($nombre, $precio, $cantidad, $presentacion, $fecha_caducidad, $id_proveedor, $necesita_receta) {

        $sql = "INSERT INTO producto 
                (nombre_producto, precio_producto, cantidad_existente, presentacion_producto,
                fecha_caducidad, id_proveedor, necesita_receta)
                VALUES (:nombre, :precio, :cantidad, :presentacion, :fecha_caducidad, 
                        :id_proveedor, :necesita_receta)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':presentacion', $presentacion);
        $stmt->bindParam(':fecha_caducidad', $fecha_caducidad);
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
                fecha_caducidad, id_proveedor, necesita_receta)
                VALUES (:nombre, :presentacion, :precio, :cantidad, :caducidad, :proveedor, :receta)";

            $stmt = $this->db->prepare($sqlProducto);
            $stmt->execute([
                ':nombre'       => $data['nombre'],
                ':presentacion' => $data['presentacion'],
                ':precio'       => $data['precio'],
                ':cantidad'     => $data['cantidad'],
                ':caducidad'    => $data['caducidad'],
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


    // Eliminar producto
    public function eliminarProducto($id) {
        $sql = "DELETE FROM producto WHERE id_producto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
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
    
    // Obtener todas las compras
    public function obtenerCompras() {
        $sql = "SELECT *
                FROM compra_producto c
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
        $sql = "DELETE FROM proveedor WHERE id_proveedor = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>       