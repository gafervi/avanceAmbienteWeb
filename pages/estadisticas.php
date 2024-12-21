<?php
session_start();
include '../includes/db.php';

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


// Obtener los gastos por categoría
$stmt_categorias = $conn->prepare("SELECT categoria, SUM(monto) AS total_categoria FROM egresos WHERE usuario_id = ? GROUP BY categoria");
$stmt_categorias->execute([$usuario_id]);
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);


$graficos = [];
foreach ($categorias as $categoria) {
    // Asegurarse de que $total_categoria y $total_egresos sean valores válidos
    $total_categoria = (float)$categoria['total_categoria'];
    $total_egresos = (float)$total_egresos;

    // Si $total_egresos es 0, evitar la división por cero
    $porcentaje = $total_egresos > 0 ? ($total_categoria / $total_egresos) * 100 : 0;

    // Añadir a la lista de gráficos
    $graficos[] = [
        'categoria' => $categoria['categoria'],
        'total' => $total_categoria,
        'porcentaje' => round($porcentaje, 2), // Redondear el porcentaje a dos decimales
    ];
}

// Ordenar el array de categorías por el total de mayor a menor
usort($graficos, function ($a, $b) {
    return $b['total'] <=> $a['total']; // Ordenar de mayor a menor
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

    <main class="welcomeContainer">
        <h1>Estadisticas</h1>
    </main>

    <aside>
        <div class="asideContainer">
            <a class="links" href="../index.php">Menú principal</a>
            <a class="links" href="./ingresos.php">Ingresos</a>
            <a class="links" href="./egresos.php">Gastos</a>
            <a class="links" href="./metasAhorro.php">Metas de ahorro</a>
            <a class="links" href="./listaDeseos.php">Lista de deseos</a>
            <a class="links" href="./estadisticas.php">Estadisticas</a>
            <a href="../logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </aside>

    <div class="mainContent">
        <div class="moneyContainer">
            <h2>Dinero Total</h2>
            <p class="total">Total: $<?php echo number_format($dinero_total, 2); ?></p>
        </div>
    </div>

    <div class="chart-container">
        <h3>Gastos por Categoría</h3>
        <svg viewBox="0 0 32 32" width="300" height="300">
            <?php
            $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
            $start_angle = 0;
            foreach ($graficos as $index => $grafico) {
                $angle = ($grafico['porcentaje'] / 100) * 360;
                $end_angle = $start_angle + $angle;

                // Calcular las coordenadas para el arco
                $x1 = 16 + 16 * cos(deg2rad($start_angle));
                $y1 = 16 + 16 * sin(deg2rad($start_angle));
                $x2 = 16 + 16 * cos(deg2rad($end_angle));
                $y2 = 16 + 16 * sin(deg2rad($end_angle));

                // Determinar si el arco es mayor a 180 grados
                $large_arc_flag = $angle >= 180 ? 1 : 0;

                echo "<path d='M16,16 L$x1,$y1 A16,16 0 $large_arc_flag,1 $x2,$y2 Z' fill='{$colors[$index % count($colors)]}'></path>";

                $start_angle = $end_angle;
            }
            ?>
        </svg>

        <ul class="chart-legend">
            <?php foreach ($graficos as $index => $grafico): ?>
                <li>
                    <span class="color-box" style="background-color: <?php echo $colors[$index % count($colors)]; ?>"></span>
                    <?php echo htmlspecialchars($grafico['categoria']) . ': $' . number_format($grafico['total'], 2); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</body>

</html>