<?php
session_start();
require_once '../../conexion.php';
require_once '../../library/consulSQL.php';

if (isset($_POST['token'])) {
    $token = $_POST['token'];
    
    // Consulta para obtener la información de la sesión por el token
    $query = "SELECT * FROM sesiones WHERE token = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param('s', $token);
    $statement->execute();
    
    // Obtener el resultado de la consulta
    $result = $statement->get_result();
    $session = $result->fetch_assoc();
    
    if ($session) {
        // Eliminar la sesión de la base de datos
        $deleteQuery = "DELETE FROM sesiones WHERE token = ?";
        $deleteStatement = $conn->prepare($deleteQuery);
        $deleteStatement->bind_param('s', $token);
        $deleteStatement->execute();
        
        // Cerrar la sesión actual del usuario
        session_unset();
        session_destroy();
        
       
        header("location:../../index.php");
    } else {
        
        session_start();
        $_SESSION['logout']= 'Salir';
        header("location:../../index.php");
        exit;
    }
} else {
    echo 'Token de sesión no proporcionado';
}

// Cerrar la conexión a la base de datos
$conn->close();
?>