<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Deseos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style_menu.css">
  <link rel="stylesheet" href="assets/style_Deseos.css">
</head>
<body>

  <!-- Barra lateral -->
  <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
        document.getElementById('lista-deseos-link').classList.add('active');

      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

  <!-- Parte de arriaba  -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm" style="margin-left: 250px;">
    <div class="container-fluid">
      <a href="#" class="navbar-brand">Lista de deseos</a>
    </div>
  </nav>

  <div class="container mt-5 main-container" style="margin-left: 300px;">
    <div class="form-container">
      <h2>Agregar a la Lista de Deseos</h2>
      <form id="wishForm">
        <div class="input-group mb-3">
          <span class="input-group-text">Nombre</span>
          <input type="text" class="form-control" id="wishName" placeholder="Nombre del deseo" required>
        </div>
        
        <div class="input-group mb-3">
          <span class="input-group-text">₡</span>
          <input type="number" class="form-control" id="wishCost" placeholder="Costo estimado" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Prioridad</span>
            <select class="form-select" id="prioritySelect" required>
              <option value="urgente">Urgente</option>
              <option value="necesario">Necesario</option>
              <option value="opcional">Opcional</option>
            </select>
          </div>
          
        <div class="input-group mb-3">
          <span class="input-group-text">Fecha de Adición</span>
          <input type="date" class="form-control" id="wishDate" required>
        </div>

        <div class="mb-3">
          <label for="wishImage" class="form-label">Imagen del deseo</label>
          <input type="file" class="form-control" id="wishImage" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar Deseo</button>
      </form>
      <hr>
    </div>

    <!-- Filtros de prioridades -->
    <div class="container py-5">
      <h1 class="display-4 text-center mb-4">Selecciona el tipo de prioridad</h1>
      <div class="d-flex justify-content-center mb-4">
        <button class="btn btn-primary my-2" id="allButton">Lista completa de deseos</button>
        <button class="btn btn-danger my-2 ms-3" id="urgentButton">Urgente</button>
        <button class="btn btn-warning my-2 ms-3" id="necessaryButton">Necesario</button>
        <button class="btn btn-info my-2 ms-3" id="optionalButton">Opcional</button>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="wishGallery">
      </div>
    </div>
  </div>

  <script src="assets/deseosList.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
