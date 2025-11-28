<?php

include "conexion.php";

class HomeModel {

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
                                                                                               
}                                                                                              
                                                                                               
?>       