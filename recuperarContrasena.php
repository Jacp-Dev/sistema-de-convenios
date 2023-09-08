<?php
require_once './conexion.php';
include './library/SED.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $id_usuario = $_POST["id_usuario"];
    $nuevaContraseña = $_POST["nuevaContraseña"];
    $confirmarContraseña = $_POST["confirmarContraseña"];
    
    if ($nuevaContraseña === $confirmarContraseña) {
       
        $id_contrasena = md5(uniqid());
        
        
        $hashedPassword = SED::encryption($nuevaContraseña);

        // Actualiza la tabla de usuarios con la nueva contraseña encriptada y el UUID
        $updateSql = "UPDATE usuarios SET contrasena = ?, id_contrasena = ? WHERE id_usuario = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sss", $hashedPassword, $id_contrasena, $id_usuario);
        
        if ($updateStmt->execute()) {
            session_start();
            $_SESSION['actualizado'] = 'Contraseña actualiza';
            header("Refresh: 0; url=./index.php");
            exit;
        } else {
            echo "Error al actualizar la contraseña: " ;
        }

        $updateStmt->close();
    } else {
        session_start();
            $_SESSION['noCoinciden'] = 'Contraseña no coinciden';
            header("Refresh: 0; url=./recuperarContrasena.php");
            exit;
    }
} elseif (isset($_GET["code"])) {
    $code = $_GET["code"];

    $selectSql = "SELECT * FROM usuarios WHERE id_contrasena = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("s", $code);
    $selectStmt->execute();
    $result = $selectStmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $id_usuario = $user["id_usuario"];
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Actualizar contraseña</title>
            <link rel="stylesheet" href="./assets/css/login.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <div class="todo">
                <img src="./assets/img/logo-fucla.png" class="avatar" alt="logo fluca">
                <br><br>
                <h2>Actualizar la contraseña</h2>
                <form id="updateForm" method="post">
                    <input type="hidden" name="id_usuario" value="' . $id_usuario . '">
                    <div class="form-group">
                        <label for="nuevaContraseña">Nueva contraseña</label>
                        <input type="password"  maxlength="50" id="nuevaContraseña" name="nuevaContraseña" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmarContraseña">Confirmar contraseña</label>
                        <input type="password"  maxlength="50" id="confirmarContraseña" name="confirmarContraseña" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Cambiar">
                    </div>
                </form>
            </div>
        </body>
        </html>';
    } else {
        echo "Ops, url caducada, ¡ya ha sido usada!.";
        $_SESSION['noCoinciden'] = 'Url caducada';
            header("Refresh: 2; url=./index.php");
            exit;
    }

    $selectStmt->close();
}


?>
