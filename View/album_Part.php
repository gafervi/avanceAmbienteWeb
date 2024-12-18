<!doctype html>
<html lang="es" id="html" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyBalance - Mis Facturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style_Album.css" rel="stylesheet">
    <link href="assets/style_menu.css" rel="stylesheet">
  </head>
  <body>

    <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
        document.getElementById('facturas-link').classList.add('active');
      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

    <div class="navbar navbar-dark bg-dark shadow-sm" style="margin-left: 250px;">
        <a href="#" class="navbar-brand d-flex align-items-center">
          <strong>Mis Facturas</strong>
        </a>
      </div>
    </div>

    <div class="container py-5" style="margin-left: 300px; margin-top: 80px;">
      <h1 class="display-4 text-center mb-4">Selecciona el Tipo de Factura</h1>
      <div class="d-flex justify-content-center mb-4">
        <button class="btn btn-primary my-2" id="allButton">Todas las Facturas</button>
        <button class="btn btn-secondary my-2 ms-3" id="MercadoButton">Mercado</button>
        <button class="btn btn-success my-2 ms-3" id="GastosFijosButton">Gastos Fijos</button>
        <button class="btn btn-warning my-2 ms-3" id="GastosVariadosButton">Gastos Variados</button>
        <button class="btn btn-danger my-2 ms-3" id="SaludButton">Salud</button>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="facturaGallery">
        <div class="col Mercado">
          <div class="card shadow-sm" data-bs-toggle="modal" data-bs-target="#facturaModal" 
               data-name="Factura Mercado" data-amount="150" data-date="15/11/2024">
            <img src="https://chantrecords.com/wp-content/uploads/2017/02/500x500.jpg" alt="Factura Mercado" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">Factura Mercado</h5>
              <p class="card-text">Compra  Pali.</p>
            </div>
          </div>
        </div>

        <div class="col GastosFijos">
          <div class="card shadow-sm" data-bs-toggle="modal" data-bs-target="#facturaModal" 
               data-name="Factura Gas" data-amount="50" data-date="01/11/2024">
            <img src="https://chantrecords.com/wp-content/uploads/2017/02/500x500.jpg" alt="Factura Gas" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">Factura Agua</h5>
              <p class="card-text">Pago mensual del Agua.</p>
            </div>
          </div>
        </div>

        <div class="col GastosVariados">
          <div class="card shadow-sm" data-bs-toggle="modal" data-bs-target="#facturaModal" 
               data-name="Factura Ropa" data-amount="120" data-date="10/11/2024">
            <img src="https://chantrecords.com/wp-content/uploads/2017/02/500x500.jpg" alt="Factura Ropa" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">Factura Ropa</h5>
              <p class="card-text">Compra de ropa nueva.</p>
            </div>
          </div>
        </div>

        <div class="col Salud">
          <div class="card shadow-sm" data-bs-toggle="modal" data-bs-target="#facturaModal" 
               data-name="Factura Internet" data-amount="30" data-date="05/11/2024">
            <img src="https://chantrecords.com/wp-content/uploads/2017/02/500x500.jpg" alt="Factura Internet" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">Factura Dentista</h5>
              <p class="card-text">Pago por arreglo dental.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="facturaModalLabel">Detalles de la Factura</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <h5 id="facturaName"></h5>
            <ul>
              <li><strong>Monto:</strong> <span id="facturaAmount"></span> €</li>
              <li><strong>Fecha:</strong> <span id="facturaDate"></span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      document.getElementById('allButton').addEventListener('click', function() {
        showAllCategories();
      });

      document.getElementById('MercadoButton').addEventListener('click', function() {
        showCategory('Mercado');
      });

      document.getElementById('GastosFijosButton').addEventListener('click', function() {
        showCategory('GastosFijos');
      });

      document.getElementById('GastosVariadosButton').addEventListener('click', function() {
        showCategory('GastosVariados');
      });

      document.getElementById('SaludButton').addEventListener('click', function() {
        showCategory('Salud');
      });

      function showCategory(category) {
        const categories = ['Mercado', 'GastosFijos', 'GastosVariados', 'Salud'];
        categories.forEach(function(cat) {
          let elements = document.querySelectorAll(`.${cat}`);
          elements.forEach(function(element) {
            element.style.display = cat === category ? 'block' : 'none';
          });
        });
      }

      function showAllCategories() {
        const categories = ['Mercado', 'GastosFijos', 'GastosVariados', 'Salud'];
        categories.forEach(function(cat) {
          let elements = document.querySelectorAll(`.${cat}`);
          elements.forEach(function(element) {
            element.style.display = 'block';
          });
        });
      }

      const facturaModal = document.getElementById('facturaModal');
      facturaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const facturaName = button.getAttribute('data-name');
        const facturaAmount = button.getAttribute('data-amount');
        const facturaDate = button.getAttribute('data-date');

        document.getElementById('facturaName').textContent = facturaName;
        document.getElementById('facturaAmount').textContent = facturaAmount;
        document.getElementById('facturaDate').textContent = facturaDate;
      });
    </script>

    
  </body>
</html>
