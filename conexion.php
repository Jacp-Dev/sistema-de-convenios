<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "convenio";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error al conectar a MySQL: " . $conn->connect_error);
}

?>