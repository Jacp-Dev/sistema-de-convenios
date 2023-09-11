<?php
require_once '../../conexion.php';
include '../../library/SED.php';

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$pass = SED::encryption($contrasena);

// Verificar si los campos están vacíos
if (empty($nombre) || empty($correo) || empty($contrasena)) {
    session_start();
    $_SESSION['errorAddUserAlert'] = 'Todos los campos son requeridos';
    header("location:../../UI/usuario/nuevoUsuario.php");
    exit;
}

// Verificar si el correo ya está registrado
$correo_existente = false;
$correo_query = "SELECT correo FROM usuarios WHERE correo = '$correo'";
$result = $conn->query($correo_query);
if ($result->num_rows > 0) {
    $correo_existente = true;
}

if ($correo_existente) {
    session_start();
    $_SESSION['errorAddUserAlert'] = 'El correo ya está registrado';
    header("location:../../UI/usuario/nuevoUsuario.php");
    exit;
} else {
    // Preparar la consulta SQL para la inserción
    $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES ('$nombre', '$correo', '$pass')";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql) === TRUE) {
        session_start();
        $_SESSION['addUserSuccess'] = true; // Indicate successful registration
        header("location:../../UI/usuario/gestiondeusuario.php");
        exit;
    } else {
        session_start();
        $_SESSION['errorAddUserAlert'] = 'Error al registrar el usuario';
        header("location:../../UI/usuario/nuevoUsuario.php");
        exit;
    }
}
?>
