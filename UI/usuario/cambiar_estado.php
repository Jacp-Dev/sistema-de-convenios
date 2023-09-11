<?php
require_once '../../conexion.php';

$idUsuario = $_GET['id_usuario'] ?? '';
$estado = $_GET['estado'] ?? '';

if (!is_numeric($idUsuario) || !in_array($estado, array('0', '1'))) {
  echo "Parámetros inválidos.";
  exit();
}

// Obtener el rol del usuario
$queryRol = "SELECT id_roles FROM usuarios_rol WHERE id_usuario = ?";
$stmtRol = mysqli_prepare($conn, $queryRol);

if ($stmtRol) {
  mysqli_stmt_bind_param($stmtRol, "i", $idUsuario);
  mysqli_stmt_execute($stmtRol);
  mysqli_stmt_bind_result($stmtRol, $idRol);
  mysqli_stmt_fetch($stmtRol);
  mysqli_stmt_close($stmtRol);

  if ($idRol === 1 && $estado == '0') {
    echo "No se puede deshabilitar a un administrador.";
    exit();
  }

  // Actualizar el estado del usuario
  $query = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
  $stmt = mysqli_prepare($conn, $query);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ii", $estado, $idUsuario);

    if (mysqli_stmt_execute($stmt)) {
      
    } else {
      echo "Error al actualizar el estado: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
  } else {
    echo "Error en la preparación de la consulta: " . mysqli_error($conn);
  }
} else {
  echo "Error en la preparación de la consulta: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
