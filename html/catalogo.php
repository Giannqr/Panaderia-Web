<?php
include 'includes/db.php';


$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catálogo - Panes del Oeste</title>
  <link rel="stylesheet" href="../css/estilos.css"/>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
  <header class="barra-navegacion">
    <nav>
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="catalogo.php" class="activo">Catálogo</a></li>
        <li><a href="ubicacion.html">Ubicación</a></li>
        <li><a href="pedidos.html">Pedidos</a></li>
        <li><a href="cart.php">🛒</a></li>
      </ul>
    </nav>
  </header>

  
  <div class="row">
        <?php foreach ($products as $p): ?>
        <div class="contenido-catalogo">
            <div class="producto">
                <?php if ($p['image']): ?>
                    <img src="assets/<?= htmlspecialchars($p['image']) ?>" class="card-img-top">
                <?php endif; ?>
                <div class="card-body">
                    <h5><?= htmlspecialchars($p['name']) ?></h5>
                    <p><?= htmlspecialchars($p['description']) ?></p>
                    <p><strong>$<?= $p['price'] ?></strong></p>
                    <a href="add_to_cart.php?id=<?= $p['id'] ?>" class="btn btn-primary">Agregar al carrito</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

  
</body>
</html>
