<?php
// Archivo de conexión a la base de datos
require_once './conexion.php';

// Función para generar un UUID
function generateUUID() {
    if (function_exists('com_create_guid') === true) {
        
    }

    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 65535),
        mt_rand(0, 65535),
        mt_rand(0, 65535),
        mt_rand(16384, 20479),
        mt_rand(32768, 49151),
        mt_rand(0, 65535),
        mt_rand(0, 65535),
        mt_rand(0, 65535)
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["enviaremail"];

    // Consulta para verificar si el correo existe y está habilitado
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND estado = 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generar un UUID
        $uuid = generateUUID();

        // Actualizar el atributo id_contrasena con el UUID generado
        $updateSql = "UPDATE usuarios SET id_contrasena = ? WHERE correo = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $uuid, $correo);
        $updateStmt->execute();

        $resetLink = 'http://localhost/sistema-de-convenios/recuperarContrasena.php?code='.$uuid;
        

        $infoToSendEmail = array(
            'emails' => [$correo],
            'subject' => 'Recuperar contraseña🔑',
            'message' => generatePasswordResetEmail($resetLink)
        );
        

        // Envía el correo
        require_once('./API/utilities/send-mail.php');
        session_start();
        $_SESSION['correoEnviado']= 'correo enviado';
        header("Refresh: 0; url=index.php");
        

       
    } else {
        session_start();
        $_SESSION['userNotExiste']= 'User no existe';
        header("Refresh: 0; url=enviarEmail.php");
        exit;
    }

    $stmt->close();
    $updateStmt->close();
}

$conn->close();

function generatePasswordResetEmail($resetLink) {
    $message = '<html>';
    $message .= '<body>';
    $message .= '<p>Hola🤗</p>';
    $message .= '<p>Recibes este correo porque has solicitado restablecer tu contraseña en nuestro sitio web.</p>';
    $message .= '<p>Por favor, haz clic en el siguiente enlace para continuar con el proceso de restablecimiento de contraseña:</p>';
    $message .= '<p><a href="' . $resetLink . '">Restablecer Contraseña</a></p>';
    $message .= '<p>Mantenga su contraseña en absoluto sigilo y cambiela regularmente.👀</p>';
    $message .= '<p>Gracias,</p>';
    $message .= '<p>Soporte Uniclaretiana</p>';
    $message .= '</body>';
    $message .= '</html>';

    return $message;
}
?>
