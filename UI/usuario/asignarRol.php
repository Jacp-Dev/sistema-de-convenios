<?php
// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los datos del formulario
    $id_usuario = $_POST["id_usuario"];
    $id_rol = $_POST["id_roles"];

    require_once '../../conexion.php';

    // Query para insertar los datos en la tabla "usuarios_rol"
    $query_insert = "INSERT INTO usuarios_rol (id_usuario, id_roles) VALUES ('$id_usuario', '$id_rol')";

    // Ejecutamos la consulta
    if (mysqli_query($conn, $query_insert)) {
        session_start();
        $_SESSION['rolUserAlert']= 'Rol  asignado';
        header("Refresh: 2; url=gestiondeusuario.php");

    } else {
        echo "Error al realizar el insert: " . mysqli_error($conn);
    }

    // Cerramos la conexión a la base de datos
    mysqli_close($conn);
}
?>
