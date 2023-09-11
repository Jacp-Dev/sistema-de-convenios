<?php
 require_once '../../conexion.php';
// Recibir los parámetros de la URL
$idConvenio = $_GET['id_convenio'] ?? '';
$habilitado = $_GET['habilitado'] ?? '';

// Validar los parámetros
if (!is_numeric($idConvenio) || !in_array($habilitado, array('0', '1'))) {
    echo "Parámetros inválidos.";
    exit();
}

// Actualizar el estado del convenio en la base de datos
$query = "UPDATE convenio SET habilitado = ? WHERE id_convenio = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ii", $habilitado, $idConvenio);

    if (mysqli_stmt_execute($stmt)) {
        echo "Estado actualizado correctamente.";
    } else {
        echo "Error al actualizar el estado: " . mysqli_stmt_error($stmt);
    }

    // Cerrar el statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error en la preparación de la consulta: " . mysqli_error($conn);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
