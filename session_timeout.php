<?php
session_start();
require_once '../../conexion.php';

// Define el tiempo de inactividad deseado en segundos (5 minutos)
$tiempo_inactividad = 600;

// Verifica si existe la variable de tiempo de la última acción y si ha pasado el tiempo deseado
if (isset($_SESSION['last_action']) && (time() - $_SESSION['last_action'] > $tiempo_inactividad)) {
    $token = $_SESSION['token']; // Obtén el token de la sesión actual
    
    // Elimina la sesión y el registro correspondiente en la base de datos
    $deleteQuery = "DELETE FROM sesiones WHERE token = ?";
    $deleteStatement = $conn->prepare($deleteQuery);
    $deleteStatement->bind_param('s', $token);
    $deleteStatement->execute();
    
    session_unset();
    session_destroy();
}
?>

<!-- Agrega un script JavaScript para redireccionar automáticamente -->
<script type="text/javascript">
    setTimeout(function() {
        window.location.href = '../../index.php'; // Redirige a la página de inicio de sesión después de 5 minutos
    }, <?php echo $tiempo_inactividad * 1000; ?>); // Multiplica por 1000 para convertir segundos en milisegundos
</script>
