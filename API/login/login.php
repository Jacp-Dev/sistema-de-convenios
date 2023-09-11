<?php
session_start();
require_once '../../conexion.php';
require_once '../../library/consulSQL.php';
require_once '../../library/SED.php';


$data = $_POST;

function generateSessionToken()
{
    $length = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

// Validar si se recibieron los datos correctamente
if (!isset($data['email']) || !isset($data['password'])) {
    $errorResponse = 'Se requieren el correo electrónico y la contraseña';
    http_response_code(400);
    echo $errorResponse;
    exit;
}

$email = substr(consultasSQL::CleanStringText($data['email']), 0, 50); 
$password = substr(consultasSQL::CleanStringText($data['password']), 0, 50); 
$encryptPassword = SED::encryption($password);


$query = "SELECT * FROM usuarios WHERE correo = ?";
$statement = $conn->prepare($query);
$statement->bind_param('s', $email);
$statement->execute();


$result = $statement->get_result();
$usuario = $result->fetch_assoc();

if ($usuario) {
  
    if ($encryptPassword == $usuario['contrasena']) {
       
        if ($usuario['estado'] == 1) {
        
            $token = generateSessionToken();

           
            $fechaCreacion = date('Y-m-d H:i:s');
            $fechaExpiracion = date('Y-m-d H:i:s', strtotime('+1 minutes'));

           
            $query = "INSERT INTO sesiones (id_usuario, token, fecha_creacion, fecha_expiracion) VALUES (?, ?, ?, ?)";
            $statement = $conn->prepare($query);
            $statement->bind_param('isss', $usuario['id_usuario'], $token, $fechaCreacion, $fechaExpiracion);
            $statement->execute();

           
            $query = "SELECT r.id_roles, r.nombre AS nombre_rol, p.url, p.create, p.read, p.update, p.delete
                      FROM roles r
                      INNER JOIN usuarios_rol ur ON r.id_roles = ur.id_roles
                      INNER JOIN permiso_rol p ON r.id_roles = p.id_roles
                      WHERE ur.id_usuario = ?";
            $statement = $conn->prepare($query);
            $statement->bind_param('i', $usuario['id_usuario']);
            $statement->execute();

           
            $result = $statement->get_result();
            $roles = $result->fetch_all(MYSQLI_ASSOC);

            
            $rol_id = $roles[0]['id_roles']; 
            $_SESSION['rol_id'] = $rol_id;

            
            $query = "SELECT * FROM sesiones WHERE token = ?";
            $statement = $conn->prepare($query);
            $statement->bind_param('s', $token);
            $statement->execute();

            
            $result = $statement->get_result();
          
            $session = $result->fetch_assoc();

            unset($usuario['contrasena']);

           
            $_SESSION['usuario'] = $usuario;
            $_SESSION['roles'] = $roles;
            $_SESSION['token'] = $token;
            $_SESSION['session'] = $session;

            http_response_code(200);

            header("Refresh: 1; url=../../UI/convenio/convenios.php");

           
            exit;
        } else {
            session_start();
            $_SESSION['deshabilitadoUserAlert'] = 'Usuario creado';
            http_response_code(403); // 403 Forbidden
            header("Refresh: 0; url=../../index.php");
            exit;
        }
    } else {
        // Contraseña incorrecta
        session_start();
        $_SESSION['contraseñaNot'] = 'Contraseña incorrecta';
        header("Refresh: 0; url=../../index.php");
        exit;
    }
} else {
    // Usuario no encontrado
    session_start();
    $_SESSION['usuarioNot'] = 'Usuario no encontrado';
    header("Refresh: 0; url=../../index.php");
    exit;
}

?>
