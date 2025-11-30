<?php
    include_once __DIR__ . "/conexion.php";

    class AdministracionEmpleadoModel {

        private $db;

        public function __construct() {
            $this->db = conecta();
        }

        public function registrarEmpleado($nombre, $telefono, $email, $password, $fechaContratacion, $idAdmin) {

            $sql = "INSERT INTO empleado (nombre_empleado, telefono_empleado, email_empleado, `password`, fecha_contratacion, id_admin)
                    VALUES (:nombre, :telefono, :email, :password, :fecha_contratacion, :id_admin)";

            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . implode(' | ', $this->db->errorInfo()));
            }

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fecha_contratacion', $fechaContratacion);
            $stmt->bindParam(':id_admin', $idAdmin, PDO::PARAM_INT);

            return $stmt->execute();
        }

        public function obtenerEmpleados() {
            $sql = "SELECT id_empleado, nombre_empleado, telefono_empleado, 
                        email_empleado, fecha_contratacion
                    FROM empleado
                    ORDER BY id_empleado ASC";

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function eliminarEmpleado($idEmpleado) {
            $sql = "DELETE FROM empleado WHERE id_empleado = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $idEmpleado, PDO::PARAM_INT);
            return $stmt->execute();
        }

    }
?>
