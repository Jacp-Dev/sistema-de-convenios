<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enviar correo</title>
  <link rel="stylesheet" href="./assets/css/login.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="todo">
    <img src="./assets/img/logo-fucla.png" class="avatar" alt="logo fluca">
    <br><br>
    <br>
    <h2>Enviar correo</h2>
    <br> <br>
    
    <form id="loginForm" method="POST" action="./validarCorreo.php">
      
      <div class="form-group">
        <label for="enviaremail">Ingresar correo</label>
        <input type="email"  maxlength="50" id="enviaremail" name="enviaremail" required>
      </div>
      
      <div class="form-group">
    <input type="submit" value="Enviar">
    <a href="./index.php" style="font-weight: bold; color: blue;">Volver atrás</a>
</div>

    </form>
  </div>
  
</body>
</html>
<?php 
if (isset($_SESSION['userNotExiste'])) {

echo "
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Usuario no encontrado',
        text: '¡El usuario no existe o está deshabilitado!',
        showConfirmButton: false,
        timer: 3000
    });
</script>";
unset($_SESSION['userNotExiste']);
}
?>
