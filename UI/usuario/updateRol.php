<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $id_roles = $_POST["id_roles"];

    // Validar y sanitizar los datos recibidos
    $id_usuario = filter_var($id_usuario, FILTER_SANITIZE_NUMBER_INT);
    $id_roles = filter_var($id_roles, FILTER_SANITIZE_NUMBER_INT);

    if ($id_usuario === false || $id_roles === false) {
        // Manejar el error de datos no válidos
        exit("Datos inválidos");
    }

    // Establecer la conexión a la base de datos
    require_once '../../conexion.php';

    $updateQuery = "UPDATE usuarios_rol SET id_roles = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $id_roles, $id_usuario);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['updateRolSuccess'] = true;
        header("location:./gestiondeusuario.php");
        exit;
    } else {
        // Manejar el error de consulta
        echo "Error: " ;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
