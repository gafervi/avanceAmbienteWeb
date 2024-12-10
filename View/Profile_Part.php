<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBalance - Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style_menu.css">
  <link rel="stylesheet" href="assets/style_Profile.css">
</head>
<body>
  <!-- Sidebar -->
  <div id="sidebar-container"></div>
  <script>
    fetch('sidebar.php')
      .then(response => response.text())
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
        document.getElementById('profile-link').classList.add('active');
      })
      .catch(error => console.error('Error al cargar el sidebar:', error));
  </script>

  <!-- Barra  -->
  <div class="navbar navbar-dark bg-dark shadow-sm navbar-custom">
    <a href="#" class="navbar-brand d-flex align-items-center">
      <strong>Profile</strong>
    </a>
  </div>

  <!-- perfil -->
  <section class="vh-100 profile-section">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-6 mb-4 mb-lg-0">
          <div class="card mb-3">
            <div class="row g-0">
              <div class="col-md-4 text-center text-white profile-image">
                <img src="https://i0.wp.com/digitalhealthskills.com/wp-content/uploads/2022/11/3da39-no-user-image-icon-27.png?fit=500%2C500&ssl=1"
                  alt="User" class="img-fluid my-5 profile-User" />
                <h5>Nombre del Usuario</h5>
                <p>Finanzas Personales</p>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h6>Información Personal</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h6>Email</h6>
                      <p class="text-muted" id="profileEmail">ejemplo@correo.com</p>
                    </div>
                    <div class="col-6 mb-3">
                      <h6>Teléfono</h6>
                      <p class="text-muted" id="profilePhone">8888 8888</p>
                    </div>
                  </div>

                  <h6>Información Financiera</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h6>Ingresos Mensuales</h6>
                      <p class="text-muted" id="profileIncome">₡1,000,000</p>
                    </div>
                    <div class="col-6 mb-3">
                      <h6>Ahorros Actuales</h6>
                      <p class="text-muted" id="profileSavings">₡500,000</p>
                    </div>
                  </div>
                  

                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
