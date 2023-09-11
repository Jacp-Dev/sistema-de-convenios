<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_red = $_POST["nombre_red"];
    $fecha_inscripcion = $_POST["fecha_inscripcion"];
    $tipo_red = $_POST["tipo_red"];
    $caractistica_red = $_POST["caractistica_red"];
    $enlace = $_POST["enlace"];
    $objeto = $_POST["objeto"];
    $id_convenio = $_POST["id_convenio"];

    // Realizar la conexión a la base de datos (código específico puede variar)
    require_once '../../conexion.php';

    // Preparar la consulta SQL de inserción
    $query = "INSERT INTO redes (nombre_red, fecha_inscripcion, tipo_red, caractistica_red, enlace, objeto, id_convenio)
              VALUES ('$nombre_red', '$fecha_inscripcion', '$tipo_red', '$caractistica_red', '$enlace', '$objeto', '$id_convenio')";

    // Ejecutar la consulta
    if (mysqli_query($conn, $query)) {
        session_start();
        $_SESSION['createRed']= 'red';
        header("location:../../UI/redes/gestionarRedes.php");
        exit;
    } else {
        // Mostrar un mensaje de error en caso de fallo
        echo "Error al insertar el registro: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>
