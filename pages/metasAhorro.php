<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$error = "";

// Calcular el saldo total del usuario (ingresos - egresos)
$stmt_ingresos = $conn->prepare("SELECT SUM(monto) AS total_ingresos FROM ingresos WHERE usuario_id = ?");
$stmt_ingresos->execute([$usuario_id]);
$total_ingresos = $stmt_ingresos->fetchColumn() ?: 0;

$stmt_egresos = $conn->prepare("SELECT SUM(monto) AS total_egresos FROM egresos WHERE usuario_id = ?");
$stmt_egresos->execute([$usuario_id]);
$total_egresos = $stmt_egresos->fetchColumn() ?: 0;

$dinero_total = $total_ingresos - $total_egresos;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $titulo = $_POST['titulo'];
    $monto = $_POST['monto'];

    if (!empty($titulo) && is_numeric($monto) && $monto > 0) {
        $stmt = $conn->prepare("INSERT INTO metas (usuario_id, titulo, monto, monto_actual) VALUES (?, ?, ?, 0)");
        $stmt->execute([$usuario_id, $titulo, $monto]);
        header("Location: metasAhorro.php");
    } else {
        $error = "Por favor, ingresa un título válido y un monto mayor a 0.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $meta_id = $_POST['meta_id'];
    $nuevo_monto = $_POST['nuevo_monto'];

    if (is_numeric($nuevo_monto) && $nuevo_monto > 0) {
        $stmt = $conn->prepare("UPDATE metas SET monto = ? WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$nuevo_monto, $meta_id, $usuario_id]);
        header("Location: metasAhorro.php");
    } else {
        $error = "Por favor, ingresa un monto válido mayor a 0.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $meta_id = $_POST['meta_id'];
    $stmt = $conn->prepare("DELETE FROM metas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$meta_id, $usuario_id]);
    header("Location: metasAhorro.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ahorrar'])) {
    $meta_id = $_POST['meta_id'];
    $monto_ahorro = $_POST['monto_ahorro'];

    if (is_numeric($monto_ahorro) && $monto_ahorro > 0 && $monto_ahorro <= $dinero_total) {
        $stmt = $conn->prepare("UPDATE metas SET monto_actual = monto_actual + ? WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$monto_ahorro, $meta_id, $usuario_id]);

        // Reducir el saldo total disponible
        $stmt = $conn->prepare("INSERT INTO egresos (usuario_id, monto, descripcion, categoria) VALUES (?, ?, 'Ahorro para meta', 'Ahorro')");
        $stmt->execute([$usuario_id, $monto_ahorro]);
        header("Location: metasAhorro.php");
    } else {
        $error = "Por favor, ingresa un monto válido menor o igual al saldo disponible.";
    }
}

$stmt = $conn->prepare("SELECT * FROM metas WHERE usuario_id = ? ORDER BY id DESC");
$stmt->execute([$usuario_id]);
$metas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metas de Ahorro</title>
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
        <h1 class="text-center">Metas de Ahorro</h1>

        <div class="alert alert-info text-center">
            <h5>Saldo Total Disponible: $<?= number_format($dinero_total, 2) ?></h5>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Definir Nueva Meta</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la Meta</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ejemplo: Ahorro para unas vacaciones" required>
                    </div>
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto Objetivo</label>
                        <input type="number" name="monto" id="monto" class="form-control" placeholder="Ejemplo: 5000" required>
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar Meta</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Metas Actuales</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Monto Objetivo</th>
                            <th>Monto Ahorrado</th>
                            <th>Saldo Disponible</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($metas)): ?>
                            <?php foreach ($metas as $index => $meta): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($meta['titulo']) ?></td>
                                    <td>$<?= number_format($meta['monto'], 2) ?></td>
                                    <td>$<?= number_format($meta['monto_actual'], 2) ?></td>
                                    <td>$<?= number_format($dinero_total, 2) ?></td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="meta_id" value="<?= $meta['id'] ?>">
                                            <input type="number" name="nuevo_monto" class="form-control mb-2" placeholder="Nuevo monto" required>
                                            <button type="submit" name="editar" class="btn btn-warning btn-sm">Editar</button>
                                        </form>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="meta_id" value="<?= $meta['id'] ?>">
                                            <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="meta_id" value="<?= $meta['id'] ?>">
                                            <input type="number" name="monto_ahorro" class="form-control mb-2" placeholder="Ahorro" required>
                                            <button type="submit" name="ahorrar" class="btn btn-success btn-sm">Ahorrar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No tienes metas definidas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>