<?php
// Conexión a la base de datos (reemplaza con tus datos de conexión)
require_once '../../conexion.php';

$id_redes = $_GET['id_redes'] ?? '';


if (empty($id_redes)) {
    echo "ID de red no proporcionado.";
    exit();
}

$query = "DELETE FROM redes WHERE id_redes = ?";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo "Error en la consulta preparada: " . mysqli_error($conn);
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $id_redes); 
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    $_SESSION['deleteRed']= 'Dred';
        header("location:../../UI/redes/gestionarRedes.php");
        exit;
} else {
    echo "No se encontró ninguna red con ese ID.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
