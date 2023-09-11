<?php
require_once '../../conexion.php';

if (isset($_GET['id_convenio'])) {
    $id_convenio = $_GET['id_convenio'];

    // Obtener el nombre del archivo asociado al convenio
    $query_select = "SELECT cargar_pdf FROM convenio WHERE id_convenio=?";
    $stmt_select = mysqli_prepare($conn, $query_select);
    mysqli_stmt_bind_param($stmt_select, "i", $id_convenio);
    mysqli_stmt_execute($stmt_select);
    mysqli_stmt_bind_result($stmt_select, $archivo_convenio);

    if (mysqli_stmt_fetch($stmt_select)) {
        // Cerrar la consulta select antes de ejecutar la siguiente
        mysqli_stmt_close($stmt_select);

        // Eliminar el registro de la base de datos
        $query_delete = "DELETE FROM convenio WHERE id_convenio=?";
        $stmt_delete = mysqli_prepare($conn, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_convenio);

        // Eliminar el archivo asociado si existe
        $carpeta_destino = "../../PDF_Convenio/";
        $archivo_a_eliminar = $carpeta_destino . $archivo_convenio;

        if (mysqli_stmt_execute($stmt_delete)) {
            // Eliminar el archivo si existe
            if (file_exists($archivo_a_eliminar)) {
                unlink($archivo_a_eliminar);
            }

            session_start();
            $_SESSION['deletedConvenioAlert'] = 'Eliminado correctamente';
            header("location: ../../UI/convenio/listarConvenios.php");
            exit();
        } else {
            echo "Error al eliminar el convenio: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt_delete);
    } else {
        echo "No se encontró el archivo del convenio.";
    }
}

mysqli_close($conn);
?>
