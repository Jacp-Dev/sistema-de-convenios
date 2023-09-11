<?php
// Realizar la conexión a la base de datos (código específico puede variar)
require_once '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_redes = $_POST['id_redes'];
    $nombre_red = $_POST['nombre_red'];
    $fecha_inscripcion = $_POST['fecha_inscripcion'];
    $tipo_red = $_POST['tipo_red'];
    $caractistica_red = $_POST['caractistica_red'];
    $enlace = $_POST['enlace'];
    $id_convenio = $_POST['id_convenio'];
    $objeto = $_POST['objeto'];

    // Consulta UPDATE para actualizar la red por su ID
    $query = "UPDATE redes SET
                nombre_red = ?,
                fecha_inscripcion = ?,
                tipo_red = ?,
                caractistica_red = ?,
                enlace = ?,
                id_convenio = ?,
                objeto = ?
                WHERE id_redes = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssssi", $nombre_red, $fecha_inscripcion, $tipo_red, $caractistica_red, $enlace, $id_convenio, $objeto, $id_redes);
    $success = mysqli_stmt_execute($stmt);
    
    if ($success) {
        session_start();
        $_SESSION['updateRed']= 'Ured';
        header("location:../../UI/redes/gestionarRedes.php");
        exit;
    } else {
        echo "Error al actualizar la red: " . mysqli_error($conn);
    }
}
?>

