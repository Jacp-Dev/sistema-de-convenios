<?php

require_once '../../conexion.php';
include '../../library/consulSQL.php';

// Verificar que se esté utilizando el método GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array('error' => 'Método no permitido'));
    exit();
}

$response = array();

// Verificar si se proporcionó el parámetro id_convenio en la URL
if (isset($_GET['id_convenio'])) {
    $idConvenio = filter_var($_GET['id_convenio'], FILTER_SANITIZE_NUMBER_INT);

    if ($idConvenio !== false) {
        // Realizar la consulta para obtener el convenio por su ID
        $query = "SELECT * FROM convenio WHERE id_convenio = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idConvenio);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $convenio = array(
                'numero_convenio' => $row['numero_convenio'],
                'nombre_institucion' => $row['nombre_institucion'],
                'cat' => $row['cat'],
                'tipo_convenio' => $row['tipo_convenio'],
                'caracteristica' => $row['caracteristica'],
                'fecha_inscripcion' => $row['fecha_inscripcion'],
                'fecha_expiracion' => $row['fecha_expiracion'],
                'cargar_pdf' => $row['cargar_pdf'],
                'objeto_descripcion' => $row['objeto_descripcion']
            );

            $response['success'] = true;
            $response['convenio'] = $convenio;
        } else {
            $response['success'] = false;
            $response['error'] = "No se encontró un convenio con el ID proporcionado";
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = "El parámetro id_convenio no es válido";
    }
} else {
    $response['success'] = false;
    $response['error'] = "Falta el parámetro id_convenio";
}

// Establecer las cabeceras para indicar que la respuesta es en formato JSON
header('Content-Type: application/json');

// Devolver los datos de salida en formato JSON
echo json_encode($response);

$conn->close();
?>
