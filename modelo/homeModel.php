<?php

include "conexion.php";

class HomeModel {

    private $db;

    public function __construct() {
        $this->db = conecta();
    }

    public function registrarUsuario($nombre, $email, $telefono, $password) {

        $sql = "INSERT INTO cliente (nombre_cliente, telefono_cliente, email_cliente,  `password`)
                VALUES (:nombre, :telefono, :email, :password)";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            echo "<pre>";
            print_r($this->db->errorInfo());
            echo "</pre>";
            exit();
        }

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    public function validarLogin($email, $password) {

        $sql = "SELECT * FROM cliente WHERE email_cliente = :email AND  `password` = :password";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
                                                                                               
        return $stmt->fetch(PDO::FETCH_ASSOC);                                                 
    }     
    
    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM cliente WHERE email_cliente = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0; 
    }

                                                                                               
}                                                                                              
                                                                                               
?>       