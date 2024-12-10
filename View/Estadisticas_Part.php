<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBalance - Menú Lateral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style_menu.css">
  <link rel="stylesheet" href="assets/style_Dashboard.css">

  
</head>
<body>

  <!-- Barra lateral -->
  <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
        document.getElementById('estadisticas-link').classList.add('active');
      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

<div class="navbar navbar-dark bg-dark shadow-sm">
  <a href="#" class="navbar-brand d-flex align-items-center">
    <strong>Graficas</strong>
  </a>
</div>
</div>

  <!-- Contenido principal -->
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Dashboard</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
          <button type="button" class="btn btn-sm btn-outline-info">Share</button>
          <button type="button" class="btn btn-sm btn-outline-info">Export</button>
        </div>
      </div>
    </div>

    <!-- Grafico proximamnete podemos agregar mas  -->
    <canvas class="my-4 w-100" id="myChart" width="850" height="355"></canvas>

    <h2>Ingresos y Gastos Mensuales</h2>
    <div class="table-responsive small">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Mes</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Gasto</th>
            <th scope="col">total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Enero</td>
            <td>₡500</td>
            <td>₡150</td>
            <td>₡350</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Febrero</td>
            <td>₡450</td>
            <td>₡200</td>
            <td>₡250</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Marzo</td>
            <td>₡600</td>
            <td>₡100</td>
            <td>₡500</td>
          </tr>
          <tr>
            <td>4</td>
            <td>Abril</td>
            <td>₡700</td>
            <td>₡120</td>
            <td>₡580</td>
          </tr>
          <tr>
            <td>5</td>
            <td>Mayo</td>
            <td>₡550</td>
            <td>₡180</td>
            <td>₡370</td>
          </tr>
          <tr>
            <td>6</td>
            <td>Junio</td>
            <td>₡450</td>
            <td>₡250</td>
            <td>₡200</td>
          </tr>
          <tr>
            <td>7</td>
            <td>Julio</td>
            <td>₡650</td>
            <td>₡300</td>
            <td>₡350</td>
          </tr>
          <tr>
            <td>8</td>
            <td>Agosto</td>
            <td>₡700</td>
            <td>₡220</td>
            <td>₡480</td>
          </tr>
          <tr>
            <td>9</td>
            <td>Septiembre</td>
            <td>₡550</td>
            <td>₡190</td>
            <td>₡360</td>
          </tr>
          <tr>
            <td>10</td>
            <td>Octubre</td>
            <td>₡750</td>
            <td>₡210</td>
            <td>₡540</td>
          </tr>
          <tr>
            <td>11</td>
            <td>Noviembre</td>
            <td>₡800</td>
            <td>₡300</td>
            <td>₡500</td>
          </tr>
          <tr>
            <td>12</td>
            <td>Diciembre</td>
            <td>₡900</td>
            <td>₡250</td>
            <td>₡650</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>

const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar', // de barras
      data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], // Todos los meses
        datasets: [
          {
            label: 'Ingreso',
            data: [500, 450, 600, 700, 550, 450, 650, 700, 550, 750, 800, 900], 
            backgroundColor: 'rgba(75, 192, 192, 0.5)', 
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          },
          {
            label: 'Gasto',
            data: [150, 200, 100, 120, 180, 250, 300, 220, 190, 210, 300, 250], 
            backgroundColor: 'rgba(255, 99, 132, 0.5)', 
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
