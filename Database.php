<?php
//Conexion a la Base de datos
$server = 'localhost';
$username = 'clinicaolympus_espe';
$password = 'tibimathy2002Est3b@n';
$database = 'clinicaolympus_scooter';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>

