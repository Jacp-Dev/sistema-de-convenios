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
    integrity="sha512-Ti7IgZr8kXW+ybRmYqP1M5Jc6bSw+flDb9ikyBKuIWSU19PrUJiG60GXTn0rIy3wjGht1c9SoqPRRXQehVd01g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../assets/css/convenio.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <title>Gestion de Convenios</title>

</head>

<body style="background: #E1E8EE;">
  <?php
  require_once '../../header.php';

  ?>
  <section>
    <div class="container espacio">
      <div class="row row-cols-1 row-cols-md-5">
        <?php
        $records_per_page = 12;
        require_once '../../conexion.php';

        $sql_count = "SELECT COUNT(*) AS total_records FROM convenio";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $total_records = $row_count['total_records'];
        $total_pages = ceil($total_records / $records_per_page);


        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $current_page = max(1, min($current_page, $total_pages));

        $offset = ($current_page - 1) * $records_per_page;

        $sql = "SELECT nombre_institucion, fecha_inscripcion FROM convenio LIMIT $offset, $records_per_page";

        $sql = "SELECT nacionalidad, COUNT(*) AS cantidad FROM convenio GROUP BY nacionalidad";
        $result = $conn->query($sql);

        // Consulta SQL para contar la cantidad de convenios próximos a vencer (vigencia mayor o igual a un día y menor o igual a un año)
        $sql_vigencia = "SELECT * FROM convenio WHERE DATEDIFF(fecha_expiracion, NOW()) >= 1 AND DATEDIFF(fecha_expiracion, NOW()) <= 365";
        $result_vigencia = $conn->query($sql_vigencia);
        $cantidad_vigencia = $result_vigencia->num_rows;

        // Consulta SQL para contar la cantidad de convenios vigentes (vigencia mayor a un año)
        $sql_vigente = "SELECT * FROM convenio WHERE DATEDIFF(fecha_expiracion, NOW()) > 365";
        $result_vigente = $conn->query($sql_vigente);
        $cantidad_vigente = $result_vigente->num_rows;

        // Consulta SQL para contar la cantidad de convenios vencidos (vigencia menor a un día)
        $sql_vencidos = "SELECT * FROM convenio WHERE DATEDIFF(NOW(), fecha_expiracion) > 0";
        $result_vencidos = $conn->query($sql_vencidos);
        $cantidad_vencidos = $result_vencidos->num_rows;

        $conn->close();
        ?>

        <div class="chart-container" style="position: relative; height:400px; width:800px;">
          <canvas id="myChart"></canvas>
        </div>
      </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var ctx = document.getElementById('myChart').getContext('2d');

    var data = {
      labels: ['Vigentes', 'Próximos a vencer', 'Vencidos'],
      datasets: [{
        label: 'Fundación Universitaria Claretiana -UNICLARETIANA-',
        data: [<?php echo $cantidad_vigente; ?>, <?php echo $cantidad_vencidos; ?>, <?php echo $cantidad_vigencia; ?>],
        backgroundColor: ['#4CAF50', '#ffc736', '#FF5733']
      }]
    };

    var options = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0 // Para mostrar valores enteros en el eje Y
          }
        }
      },
      plugins: {
        title: {
          display: true,
          text: 'Total de convenios Uniclaretiana: <?php echo $cantidad_vigente + $cantidad_vencidos + $cantidad_vigencia; ?>',
          font: {
            size: 20
          }
        },
        legend: {
          display: true,
          position: 'bottom'
        },
        annotation: {
          annotations: {
            total: {
              type: 'text',
              x: 'center',
              y: 'center',
              fontColor: '#333',
              fontSize: 16
            }
          }
        }
      }
    };

    var myChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: options
    });

    // Aplicar estilos al contenedor del gráfico
    var chartContainer = document.querySelector('.chart-container');
    chartContainer.style.position = 'relative';
    chartContainer.style.height = '400px';
    chartContainer.style.width = '800px';
    chartContainer.style.marginTop = '50px'; // Ajustar hacia abajo
    chartContainer.style.marginLeft = 'auto'; // Centrar horizontalmente
    chartContainer.style.marginRight = 'auto'; // Centrar horizontalmente
    chartContainer.style.backgroundColor = '#ffffff';
    chartContainer.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.2)';
    chartContainer.style.padding = '20px';
    chartContainer.style.borderRadius = '10px';
  </script>





</body>
<footer>
  <div class="container">
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p style="color: gray;">Echo con ❤️ por el estudiante: José Alirio Cabrera Palacios...</p>
  </div>
</footer>

</html>