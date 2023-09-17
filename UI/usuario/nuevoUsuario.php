<?php
session_start();
error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/convenio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <link rel="icon" href="../../assets/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <title>Registrar Usuario</title>
</head>

<body style="background: #E1E8EE;">
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../convenio/convenios.php"><img src="../../assets/img/logo-fucla.png"
                        alt="Logo Fucla"></a>
                <div class="separador-vertical"></div>

                <a class="navbar-brand text-warning fs-1" href="../convenio/convenios.php">Gestión de usuarios</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                        <ul class="menu">
                            <ul class="menu">
                                <li><a href="../convenio/grafico.php"><i class="fas fa-chart-bar"
                                            style="color: #DF6914"></i> Ver
                                        gráfico</a></li>
                                <li><a href="../usuario/gestiondeusuario.php"><i class="fas fa-users"
                                            style="color: #DF6914"></i> Gestión
                                        de usuarios</a></li>
                                <li><a href="../convenio/convenios.php"><i class="fas fa-folder"
                                            style="color: #DF6914"></i> Gestión de
                                        convenios</a></li>
                                <li><a href="../redes/DashboardRedes.php"><i class="fas fa-network-wired"
                                            style="color: #DF6914"></i>
                                        Gestión
                                        de redes</a></li>

                                <?php
                                session_start();
                                if (isset($_SESSION['token'])) {
                                    $token = $_SESSION['token'];
                                } else {
                                    // Contraseña incorrecta
                                    session_start();
                                    $_SESSION['tokenNot'] = 'token incorrecto';

                                    header("Refresh: 0; url=../../index.php");
                                    exit;
                                }
                                ?>
                                <li>

                                    <form action="../../API/login/logout.php" method="post"
                                        style="display: flex; align-items: center;">
                                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                                        <button type="submit" id="logout"
                                            style="border: none; background: none; cursor: pointer;">
                                            <i class="fas fa-sign-out-alt" style="color: #DF6914"></i>
                                            Salir
                                        </button>
                                    </form>

                                </li>
                            </ul>
                        </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-3">
        <p class="fs-4"> <i class="fas fa-users" style="color: #DF6914"></i> Registrar nuevo usuario
        </p>
        <p>En esta sección podrás registrar un nuevo usuario diligenciando el siguiente formulario.</p>
        <form action="../../API/usuario/registrar_usuario.php" method="post" id="registroForm">
            <div class="row">
                <div class="col">
                    <label for="">Nombre de usuario</label>
                    <input type="text" class="form-control" name="nombre" required maxlength="50">
                </div>
                <div class="col">
                    <label for="">Correo</label>
                    <input type="text" class="form-control" name="correo" id="correo" required maxlength="50">
                    <div id="errorMensaje" style="display: none; color: red;">El correo ingresado no está permitido
                    </div>
                </div>
                <div class="col">
                    <label for="">Contraseña</label>
                    <input type="password" class="form-control" name="contrasena" required maxlength="50">
                </div>
            </div>
            <nav class="navbar navbar-expand-lg">
                <div class="navbar-nav ms-auto ms-auto mb-2 mb-lg-0">
                    <a href="./gestiondeusuario.php" class="btn btn-outline-secondary"
                        style="margin-right: 5px;">Cancelar</a>
                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                </div>
            </nav>
        </form>


    </div>
    <script>
        document.getElementById("registroForm").addEventListener("submit", function (event) {
            const emailValue = document.querySelector("#correo").value.trim().toLowerCase();
            const inputText = document.querySelector("#correo");
            const errorMensaje = document.querySelector("#errorMensaje");
            const archivoInput = document.querySelector(".form-control[name='correo']");

            if (!emailValue.endsWith("@uniclaretiana.edu.co") && !emailValue.endsWith("@miuniclaretiana.edu.co")) {
                inputText.value = '';
                errorMensaje.style.display = 'block';
                archivoInput.style.borderColor = 'red';
                event.preventDefault();
            }
        });

    </script>

    <script src="https://kit.fontawesome.com/4b93f520b2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
if (isset($_SESSION['errorAddUserAlert'])) {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Registro inválido',
        text: '¡El usuario ya está registrado!',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['errorAddUserAlert']);
}
if (isset($_SESSION['errorAddUserAlert'])) {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Registro inválido',
        text: '¡El usuario ya está registrado!',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['errorAddUserAlert']);
}
?>
