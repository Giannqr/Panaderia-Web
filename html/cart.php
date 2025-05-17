<?php
include 'includes/db.php';
session_start();

if ($_POST && isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    foreach ($_POST['quantity'] as $cart_id => $qty) {
        $qty = max(1, intval($qty));
        if (is_numeric($cart_id)) {
            $stmt->execute([$qty, $cart_id]);
        }
    }
    header("Location: cart.php?updated=1");
    exit;
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: cart.php?deleted=1");
    exit;
}
$stmt = $pdo->prepare("
    SELECT c.id, p.name, p.price, p.image, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
");
$stmt->execute(); 
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
      <link rel="stylesheet" href="../css/crud.css">
    <title>Carrito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        img { width: 80px; height: 80px; object-fit: cover; }
    </style>
</head>
<body class="container">
    <h2 class="text-muted">Mi Carrito</h2>
    <a href="catalogo.php" class="btn btn-secondary">Volver al catálogo</a>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success mt-3">Carrito actualizado correctamente.</div>
    <?php elseif (isset($_GET['deleted'])): ?>
        <div class="alert alert-warning mt-3">Producto eliminado del carrito.</div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <table class="table table-bordered">
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
            <?php
            $total = 0;
            foreach ($items as $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td>
                    <?php if ($item['image']): ?>
                        <img src="assets/<?= htmlspecialchars($item['image']) ?>" alt="">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>
                    <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width:80px;">
                </td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td>
                    <a href="cart.php?delete=<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h4 class="text-white">Total: $<?= number_format($total, 2) ?></h4>

        <?php if (count($items) > 0): ?>
            <button name="update" class="btn btn-primary">Actualizar cantidades</button>
        <?php else: ?>
            <p>No tienes productos en tu carrito.</p>
        <?php endif; ?>
    </form>
</body>
</html>
