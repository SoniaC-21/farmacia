<?php

    //include "conexion.php";
    include_once __DIR__ . "/conexion.php";

    class HomeModel {

        private $db;

        public function __construct() {
            $this->db = conecta();
        }

        public function validarLogin($email, $password) {

            $sql = "SELECT * FROM `admin` WHERE email = :email AND  `password` = :password";

<<<<<<< HEAD
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
                                                                                               
        return $stmt->fetch(PDO::FETCH_ASSOC);                                                 
    } 
    
    
                                                                                               
}                                                                                              
                                                                                               
=======
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
                                                                                                
            return $stmt->fetch(PDO::FETCH_ASSOC);                                                 
        }                                                                                          
                                                                                                
    }                                                                                                                                                                                     
>>>>>>> origin/Arely
?>       