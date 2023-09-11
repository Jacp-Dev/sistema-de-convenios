<?php
require_once '../../conexion.php';

$idUsuario = $_GET['id_usuario'] ?? '';
$alerta = $_GET['alerta'] ?? '';

if (!is_numeric($idUsuario) || !in_array($alerta, array('0', '1'))) {
  echo "Parámetros inválidos.";
  exit();
}

// Actualizar el campo 'alerta' del usuario
$query = "UPDATE usuarios SET alerta = ? WHERE id_usuario = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
  mysqli_stmt_bind_param($stmt, "ii", $alerta, $idUsuario);

  if (mysqli_stmt_execute($stmt)) {
    echo "alerta actualizado con éxito.";
  } else {
    echo "Error al actualizar el alerta: " . mysqli_stmt_error($stmt);
  }

  mysqli_stmt_close($stmt);
} else {
  echo "Error en la preparación de la consulta: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
