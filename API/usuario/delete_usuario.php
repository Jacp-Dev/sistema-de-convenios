<?php
// Conexión a la base de datos (reemplaza con tus datos de conexión)
require_once '../../conexion.php';

// Obtener el ID del usuario a eliminar
$idUsuario = $_GET['id_usuario'] ?? '';

if (!empty($idUsuario)) {
    // Verificar el rol del usuario antes de eliminar
    $queryRol = "SELECT id_roles FROM usuarios_rol WHERE id_usuario = ?";
    $stmtRol = mysqli_prepare($conn, $queryRol);

    if ($stmtRol) {
        mysqli_stmt_bind_param($stmtRol, "i", $idUsuario);
        mysqli_stmt_execute($stmtRol);
        mysqli_stmt_bind_result($stmtRol, $idRol);
        mysqli_stmt_fetch($stmtRol);
        mysqli_stmt_close($stmtRol);

        if ($idRol === 1) {
            session_start();
                $_SESSION['notDetetedUserAdmin'] = 'No se puede';
                header("Location:../../UI/usuario/gestiondeusuario.php");
                exit();
        }

        // Proceder con la eliminación del usuario
        $query = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idUsuario);

            if (mysqli_stmt_execute($stmt)) {
                session_start();
                $_SESSION['detetedUserAlert'] = 'Se ha eliminado correctamente';
                header("Location:../../UI/usuario/gestiondeusuario.php");
                exit();
            } else {
                echo "Error al eliminar el usuario: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($conn);
        }
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conn);
    }
} else {
    echo "ID de usuario no proporcionado.";
}

mysqli_close($conn);
?>
