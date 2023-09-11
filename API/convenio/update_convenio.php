<?php

require_once '../../conexion.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_convenio = isset($_POST['id_convenio']) ? $_POST['id_convenio'] : '';
    $nombre_institucion = isset($_POST['nombre_institucion']) ? $_POST['nombre_institucion'] : '';
    $slug = crearSlug($nombre_institucion);
    $id_cat = isset($_POST['id']) ? $_POST['id'] : '';
    $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : '';
    $caracteristica = isset($_POST['caracteristica']) ? $_POST['caracteristica'] : '';
    $fecha_inscripcion = isset($_POST['fecha_inscripcion']) ? $_POST['fecha_inscripcion'] : '';
    $fecha_expiracion = isset($_POST['fecha_expiracion']) ? $_POST['fecha_expiracion'] : '';
    $numero_convenio = isset($_POST['numero_convenio']) ? $_POST['numero_convenio'] : '';
    $tipo_convenio = isset($_POST['tipo_convenio']) ? $_POST['tipo_convenio'] : '';
    $objeto_descripcion = isset($_POST['objeto_descripcion']) ? $_POST['objeto_descripcion'] : '';

    $fecha_actual = new DateTime();
    $fecha_expiracion_format = new DateTime($fecha_expiracion);
    $diferencia = date_diff($fecha_actual, $fecha_expiracion_format);
    $diferencia = $diferencia->format('%R%a');
    
    // Verificamos si se ha cargado un nuevo archivo
    if (isset($_FILES['archivo']['name']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $cargar_pdf = time() . "_" . $_FILES['archivo']['name'];
        $archivo_temporal = $_FILES['archivo']['tmp_name'];
        $carpeta_destino = "../../PDF_Convenio/";

        // Movemos el archivo a la carpeta deseada
        if (move_uploaded_file($archivo_temporal, $carpeta_destino . $cargar_pdf)) {
            // Archivo subido correctamente, actualiza el nombre del archivo en la base de datos
            $query = "UPDATE convenio SET 
                nombre_institucion=?, 
                caracteristica=?, 
                nacionalidad=?, 
                fecha_inscripcion=?, 
                fecha_expiracion=?, 
                numero_convenio=?, 
                tipo_convenio=?, 
                objeto_descripcion=?, 
                slug=?,
                cargar_pdf=?
                WHERE id_convenio=?";
            
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssssssssi", $nombre_institucion, $caracteristica, $nacionalidad, $fecha_inscripcion, $fecha_expiracion, $numero_convenio, $tipo_convenio, $objeto_descripcion, $slug, $cargar_pdf, $id_convenio, );
        } else {
            echo "Error al subir el archivo.\n";
            exit(); // Termina el script si hay un error al subir el archivo
        }
    } else {
        $cargar_pdf = ""; // Si no se ha enviado un archivo, dejar el nombre vacío
        // Consulta SQL sin actualizar el campo del archivo
        $query = "UPDATE convenio SET 
            nombre_institucion=?, 
            caracteristica=?, 
            nacionalidad=?, 
            fecha_inscripcion=?, 
            fecha_expiracion=?, 
            numero_convenio=?, 
            tipo_convenio=?, 
            objeto_descripcion=?, 
            slug=?
            WHERE id_convenio=?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssi", $nombre_institucion, $caracteristica, $nacionalidad, $fecha_inscripcion, $fecha_expiracion, $numero_convenio, $tipo_convenio, $objeto_descripcion, $slug, $id_convenio);
    }

    // Ejecutar el query
    if (mysqli_stmt_execute($stmt)) {
        session_start();
        $_SESSION['updateConvenio'] = 'Uconvenio';
        sendMail($conn, $nombre_institucion, $objeto_descripcion);
        header("location:../../UI/convenio/listarConvenios.php");
        exit();
    } else {
        echo "Error al actualizar el convenio: " . mysqli_error($conn);
    }

    // Cerrar la declaración preparada
    mysqli_stmt_close($stmt);
}


function sendMail($conn, $nombre, $descripcion)
{

    $query = "SELECT correo FROM usuarios WHERE estado = 1 AND alerta = 1";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if ($result->num_rows > 0) {
            $infoToSendEmail = array(
                'subject' => 'Se ha actualizado el convenio: ' . $nombre,
                'message' => $descripcion
            );

            $destinatarios = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $destinatarios[] = $row['correo'];
            }

            $infoToSendEmail['emails'] = $destinatarios;

            // Cierra la conexión
            mysqli_free_result($result);

            // Envía el correo
            require_once('../utilities/send-mail.php');
        }
    } else {
        echo "Error al obtener los correos de los usuarios: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
}


function crearSlug($texto)
{
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $texto);
    $slug = strtolower($slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>