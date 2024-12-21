<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

if (!isset($_SESSION['categorias'])) {
    $_SESSION['categorias'] = [];
}

// Insertar nuevos egresos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];

    if ($categoria === 'Otro' && isset($_POST['otra_categoria']) && !empty(trim($_POST['otra_categoria']))) {
        $categoria = trim($_POST['otra_categoria']);
    }

    if ($monto > 0) {
        $stmt = $conn->prepare("INSERT INTO egresos (usuario_id, monto, descripcion, categoria) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$usuario_id, $monto, $descripcion, $categoria])) {
            $mensaje = "Egreso registrado exitosamente.";
        } else {
            $mensaje = "Hubo un error al registrar el egreso.";
        }
    } else {
        $mensaje = "El monto debe ser mayor a 0.";
    }
}

// Agregar nueva categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_categoria'])) {
    $nueva_categoria = trim($_POST['nueva_categoria']);
    if (!empty($nueva_categoria) && !in_array($nueva_categoria, $_SESSION['categorias'])) {
        $_SESSION['categorias'][] = $nueva_categoria;
        $mensaje = "Categoría agregada exitosamente.";
    }
}

// Categorías predefinidas
$categorias_predefinidas = ['Comida', 'Servicios básicos', 'Transporte', 'Vestimenta', 'Otro'];

// Combinar categorías predefinidas y personalizadas
$categorias_disponibles = array_merge($categorias_predefinidas, $_SESSION['categorias']);

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'fecha DESC'; // Por defecto, ordena por fecha descendente

switch ($order_by) {
    case 'monto_desc':
        $order_query = "monto DESC";
        break;
    case 'monto_asc':
        $order_query = "monto ASC";
        break;
    case 'categoria':
        $order_query = "categoria ASC";
        break;
    default:
        $order_query = "fecha DESC";
}

// Obtener todos los egresos del usuario según el filtro seleccionado
$stmt_egresos = $conn->prepare("SELECT monto, descripcion, categoria, fecha FROM egresos WHERE usuario_id = ? ORDER BY $order_query");
$stmt_egresos->execute([$usuario_id]);
$egresos = $stmt_egresos->fetchAll();

// Obtener el total de gastos por categoría
$stmt_totales = $conn->prepare("SELECT categoria, SUM(monto) AS total FROM egresos WHERE usuario_id = ? GROUP BY categoria ORDER BY total DESC");
$stmt_totales->execute([$usuario_id]);
$totales_por_categoria = $stmt_totales->fetchAll();

// Encontrar la categoría con mayor gasto
$categoria_mayor_gasto = count($totales_por_categoria) > 0 ? $totales_por_categoria[0] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Egresos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/egresos.css">
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
    <div class="container mt-5">
        <h1 class="text-center">Gestión de Egresos</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info text-center">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title text-center">Registrar Nuevo Egreso</h2>
                <form action="" method="POST">
                    <input type="hidden" name="registrar" value="1">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" step="0.01" name="monto" id="monto" class="form-control" placeholder="Ingresa el monto del egreso" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Describe el egreso" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select name="categoria" id="categoria" class="form-control" required>
                            <?php foreach ($categorias_disponibles as $categoria): ?>
                                <option value="<?php echo htmlspecialchars($categoria); ?>"><?php echo htmlspecialchars($categoria); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Egreso</button>
                </form>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title text-center">Agregar Nueva Categoría</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="agregar_categoria" value="1">
                        <div class="mb-3">
                            <label for="nueva_categoria" class="form-label">Nombre de la Nueva Categoría</label>
                            <input type="text" name="nueva_categoria" id="nueva_categoria" class="form-control" placeholder="Ejemplo: Entretenimiento" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Agregar Categoría</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Historial de Egresos</h2>

                <!-- Formulario para filtrar egresos -->
                <form action="" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="order_by" class="form-label">Ordenar por:</label>
                            <select name="order_by" id="order_by" class="form-control">
                                <option value="fecha DESC" <?php echo $order_by === 'fecha DESC' ? 'selected' : ''; ?>>Más recientes</option>
                                <option value="monto_desc" <?php echo $order_by === 'monto_desc' ? 'selected' : ''; ?>>Monto (de mayor a menor)</option>
                                <option value="monto_asc" <?php echo $order_by === 'monto_asc' ? 'selected' : ''; ?>>Monto (de menor a mayor)</option>
                                <option value="categoria" <?php echo $order_by === 'categoria' ? 'selected' : ''; ?>>Categoría</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
                        </div>
                    </div>
                </form>

                <!-- Tabla de egresos -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Monto</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($egresos) > 0): ?>
                                <?php foreach ($egresos as $egreso): ?>
                                    <tr>
                                        <td>$<?php echo number_format($egreso['monto'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($egreso['descripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($egreso['categoria']); ?></td>
                                        <td><?php echo $egreso['fecha']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No se han registrado egresos.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Totales por categoría -->
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title text-center">Totales por Categoría</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($totales_por_categoria) > 0): ?>
                                <?php foreach ($totales_por_categoria as $total): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($total['categoria']); ?></td>
                                        <td>$<?php echo number_format($total['total'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">No se han registrado egresos.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($categoria_mayor_gasto): ?>
                    <div class="alert alert-info text-center mt-3">
                        La categoría con mayor gasto es <strong><?php echo htmlspecialchars($categoria_mayor_gasto['categoria']); ?></strong> con un total de <strong>$<?php echo number_format($categoria_mayor_gasto['total'], 2); ?></strong>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>