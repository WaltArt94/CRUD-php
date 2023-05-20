<?php

//Conexion a la DB
$host = "localhost";    
$bd="php-crud-basic";
$user = "root";
$password = "0512";


try {
    $conection=new PDO("mysql:host=$host;dbname=$bd", $user,$password);
    // if($conection){echo "Successful conection";}
} catch (Exception $e) {
    echo $e->getMessage();
}



?>