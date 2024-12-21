<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['usuario_id'];

// Consultar ingresos y egresos totales del usuario
$stmt_ingresos = $conn->prepare("SELECT SUM(monto) AS total_ingresos FROM ingresos WHERE usuario_id = ?");
$stmt_ingresos->execute([$usuario_id]);
$total_ingresos = $stmt_ingresos->fetchColumn() ?: 0;

$stmt_egresos = $conn->prepare("SELECT SUM(monto) AS total_egresos FROM egresos WHERE usuario_id = ?");
$stmt_egresos->execute([$usuario_id]);
$total_egresos = $stmt_egresos->fetchColumn() ?: 0;


$dinero_total = $total_ingresos - $total_egresos;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>

    <main class="welcomeContainer">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h1>
    </main>

    <aside>
        <div class="asideContainer">
            <a class="links" href="pages/ingresos.php">Ingresos</a>
            <a class="links" href="pages/egresos.php">Gastos</a>
            <a class="links" href="pages/metasAhorro.php">Metas de ahorro</a>
            <a class="links" href="pages/listaDeseos.php">Lista de deseos</a>
            <a class="links" href="pages/estadisticas.php">Estadisticas</a>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </aside>

    <div class="mainContent">
        <div class="moneyContainer">
            <h2>Dinero Total</h2>
            <p class="total">Total: $<?php echo number_format($dinero_total, 2); ?></p>
        </div>
    </div>

    <div class="imgsContainer">
        <img class="finanzas_Img" src="./assets/imgs/finanzas.png" alt="">
    </div>
</body>

</html>