<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$error = "";

// Agregar un deseo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $deseo = $_POST['deseo'];
    $monto = $_POST['monto'];

    if (!empty($deseo) && is_numeric($monto) && $monto > 0) {
        $stmt = $conn->prepare("INSERT INTO deseos (usuario_id, descripcion, monto) VALUES (?, ?, ?)");
        $stmt->execute([$usuario_id, $deseo, $monto]);
        header("Location: listaDeseos.php");
    } else {
        $error = "Por favor, ingresa un deseo y un monto válido.";
    }
}

// Editar un deseo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $deseo_id = $_POST['deseo_id'];
    $nuevo_monto = $_POST['nuevo_monto'];

    if (is_numeric($nuevo_monto) && $nuevo_monto > 0) {
        $stmt = $conn->prepare("UPDATE deseos SET monto = ? WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$nuevo_monto, $deseo_id, $usuario_id]);
        header("Location: listaDeseos.php");
    } else {
        $error = "Por favor, ingresa un monto válido mayor a 0.";
    }
}

// Eliminar un deseo
if (isset($_GET['eliminar'])) {
    $deseo_id = $_GET['eliminar'];

    $stmt = $conn->prepare("DELETE FROM deseos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$deseo_id, $usuario_id]);
    header("Location: listaDeseos.php");
}

$stmt = $conn->prepare("SELECT * FROM deseos WHERE usuario_id = ? ORDER BY id DESC");
$stmt->execute([$usuario_id]);
$deseos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/deseos.css">
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
        <h1 class="text-center">Lista de Deseos</h1>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Agregar un Nuevo Deseo</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="deseo" class="form-label">Deseo</label>
                        <input type="text" name="deseo" id="deseo" class="form-control" placeholder="Ingresa tu deseo" required>
                    </div>
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" name="monto" id="monto" class="form-control" placeholder="Ingresa el monto" required>
                    </div>
                    <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Tus Deseos</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($deseos)): ?>
                            <?php foreach ($deseos as $index => $deseo): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($deseo['descripcion']) ?></td>
                                    <td>$<?= number_format($deseo['monto'], 2) ?></td>
                                    <td>
                                        <!-- Formulario para editar -->
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="deseo_id" value="<?= $deseo['id'] ?>">
                                            <input type="number" name="nuevo_monto" class="form-control mb-2" placeholder="Nuevo monto" required>
                                            <button type="submit" name="editar" class="btn btn-warning btn-sm">Editar</button>
                                        </form>
                                        <a href="listaDeseos.php?eliminar=<?= $deseo['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este deseo?');">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay deseos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>