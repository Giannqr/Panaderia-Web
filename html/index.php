<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
     <link rel="stylesheet" href="../css/crud.css"/>
    <title>Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        img { height: 200px; object-fit: cover; }
    </style>
</head>
<body class="container">
    <h2>Bienvenido a la tienda</h2>
    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    <a href="register.php" class="btn btn-secondary">Registro Usuarios</a>
    <a href="crud.php" class="btn btn-secondary">Gestionar Productos</a>
   
    <hr>
    <div class="row">
        <?php foreach ($products as $p): ?>
        <div class="col-md-4">
            <div class="card mb-3">
                <?php if ($p['image']): ?>
                    <img src="assets/<?= htmlspecialchars($p['image']) ?>" class="card-img-top">
                <?php endif; ?>
                <div class="card-body">
                    <h5><?= htmlspecialchars($p['name']) ?></h5>
                    <p><?= htmlspecialchars($p['description']) ?></p>
                    <p><strong>$<?= $p['price'] ?></strong></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
