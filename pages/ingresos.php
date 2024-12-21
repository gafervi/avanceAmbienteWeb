<?php
session_start();
include '../includes/db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id']; // ID del usuario logueado
$error = "";

// Si se envía el formulario, registra un nuevo ingreso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];

    if (!empty($monto) && is_numeric($monto)) {
        $stmt = $conn->prepare("INSERT INTO ingresos (usuario_id, monto, descripcion) VALUES (?, ?, ?)");
        $stmt->execute([$usuario_id, $monto, $descripcion]);
        header("Location: ingresos.php"); // Recarga la página para evitar reenvíos duplicados
    } else {
        $error = "Por favor, ingresa un monto válido.";
    }
}

// Obtiene los ingresos del usuario
$stmt = $conn->prepare("SELECT * FROM ingresos WHERE usuario_id = ? ORDER BY fecha DESC");
$stmt->execute([$usuario_id]);
$ingresos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

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
    <div class="container mt-4">
        <h1 class="text-center">Registro de Ingresos</h1>

        <!-- Formulario para agregar ingresos -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Registrar Nuevo Ingreso</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" name="monto" id="monto" class="form-control" placeholder="Ingresa el monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del ingreso">
                    </div>
                    <button type="submit" class="btn btn-success">Registrar</button>
                </form>
            </div>
        </div>

        <!-- Tabla de ingresos -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Historial de Ingresos</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Monto</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ingresos)): ?>
                            <?php foreach ($ingresos as $index => $ingreso): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>$<?= number_format($ingreso['monto'], 2) ?></td>
                                    <td><?= htmlspecialchars($ingreso['descripcion']) ?></td>
                                    <td><?= date("d/m/Y H:i", strtotime($ingreso['fecha'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay ingresos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>