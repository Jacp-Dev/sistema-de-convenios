<?php
// Conexión a la base de datos (reemplaza con tus datos de conexión)
require_once '../../conexion.php';
if (isset($_POST['cargar_pdf'])) {
    $cargar_pdf = $_POST['cargar_pdf'];


    // Realiza una consulta a la base de datos para obtener el archivo PDF asociado al nombre del archivo
    // (Recuerda escapar adecuadamente el valor para evitar inyección de SQL)
    $consulta = "SELECT cargar_pdf FROM convenio WHERE cargar_pdf = ?";
    $stmt = mysqli_prepare($conn, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $cargar_pdf);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            $pdf_blob = $fila['cargar_pdf'];

            // Configurar las cabeceras para forzar la descarga del archivo PDF
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=\"" . str_replace("/", "\\", $cargar_pdf) . "\"");


            // Imprimir el contenido del archivo PDF y terminar la ejecución del script
            echo $pdf_blob;
            exit();
        } else {
            echo "Archivo no encontrado en la base de datos.";
        }
    } else {
        echo "Error al consultar la base de datos.";
    }

    // Cerrar la consulta preparada y la conexión a la base de datos
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "Nombre del archivo no proporcionado.";
}
?>