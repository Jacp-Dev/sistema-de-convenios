<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar - Uniclaretiana</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="./assets/css/login.css">
   <link rel="icon" href="./assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
  <div class="todo">
    <img src="./assets/img/logo-fucla.png" class="avatar" alt="logo fluca">
    <br><br>
    <h2>Iniciar Sesión</h2>
    <form id="loginForm" action="./API/login/login.php" method="post">
      <div class="form-group">
        <label for="email">Ingresar correo</label>
        <input type="email" id="email" name="email" required maxlength="50">
      </div>
      <div class="form-group">
        <label for="password">Ingresar contraseña</label>
        <input type="password" id="password" name="password" required maxlength="50">
      </div>
     <div class="form-group">
    <input type="submit" value="Ingresar" id="submitBtn" disabled>
    <a href="./enviarEmail.php" style="color: blue;">Olvidé la contraseña</a>
</div>

    </form>
  </div>

  <script>
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const submitBtn = document.getElementById("submitBtn");

    emailInput.addEventListener("input", function() {
      const emailValue = emailInput.value.trim().toLowerCase();
      const isValidEmail = emailValue.endsWith("@uniclaretiana.edu.co") || emailValue.endsWith("@miuniclaretiana.edu.co");

      if (emailValue.length > 50) {
        emailInput.style.border = "1px solid red"; // Display red border for invalid length
        submitBtn.disabled = true; // Disable the submit button
      } else if (isValidEmail) {
        emailInput.style.border = "1px solid #ccc"; // Restoring default border color
        submitBtn.disabled = false; // Enable the submit button
      } else {
        emailInput.style.border = "1px solid red"; // Display red border for invalid email
        submitBtn.disabled = true; // Disable the submit button
      }
    });

    document.getElementById("loginForm").addEventListener("submit", function(event) {
      const emailValue = emailInput.value.trim().toLowerCase();
      
      if (!emailValue.endsWith("@uniclaretiana.edu.co") && !emailValue.endsWith("@miuniclaretiana.edu.co")) {
        alert("Credenciales incorrectas");
        event.preventDefault();
      }
    });
    
  </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>scr="./loginAlert.js"</script>
</body>
</html>
<?php
if (isset($_SESSION['deshabilitadoUserAlert'])) {

echo "
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Error de inicio de sesión',
        text: '¡El usuario se encuentra deshabilitado, contacte al administrador!'
    });
</script>";
unset($_SESSION['deshabilitadoUserAlert']);
}if (isset($_SESSION['logout'])) {

  echo "
  <script>
      Swal.fire({
          icon: 'warning',
          title: 'Error de inicio de sesión',
          text: '¡Inicie sesión correctamente!'
      });
  </script>";
  unset($_SESSION['logout']);
  }
  if (isset($_SESSION['usuarioNot'])) {

    echo "
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Error de inicio de sesión',
            text: '¡Inicie sesión correctamente!',
            showConfirmButton: false,
            timer: 2000
        });
    </script>";
    unset($_SESSION['usuarioNot']);
    }
    if (isset($_SESSION['contraseñaNot'])) {

      echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Error de inicio de sesión',
              text: '¡Contraseña verifique sus credenciales!',
              showConfirmButton: false,
              timer: 2000
          });
      </script>";
      unset($_SESSION['contraseñaNot']);
      }
      if (isset($_SESSION['tokenNot'])) {

        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Token no disponible',
                text: '¡Token inválido, inicie sesión correctamente!',
                showConfirmButton: false,
                timer: 2000
            });
        </script>";
        unset($_SESSION['tokenNot']);
        }if (isset($_SESSION['actualizado'])) {
          echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Actualización exitosa',
                text: '¡La contraseña ha sido actualizada exitosamente!',
                showConfirmButton: false,
                timer: 2000
                
            }).then(() => {
               
            });
            </script>";
          unset($_SESSION['actualizado']);
        }if (isset($_SESSION['urlcaducada'])) {

          echo "
          <script>
              Swal.fire({
                  icon: 'warning',
                  title: 'Url no disponible',
                  text: '¡La url de recuperación ya ha sido usada!',
                  showConfirmButton: false,
                  timer: 3000
              });
          </script>";
          unset($_SESSION['urlcaducada']);
          }
          if (isset($_SESSION['correoEnviado'])) {
            echo "<script>
              Swal.fire({
                  icon: 'success',
                  title: 'Correo enviado',
                  text: '¡El correo de recpueración se ha enviado, revise su bandeja en entrada!',
                  showConfirmButton: false,
                  timer: 3000
                  
              }).then(() => {
                 
              });
              </script>";
            unset($_SESSION['correoEnviado']);
          }
      
?>
