    <?php
    include 'includes/db.php';
    session_start();

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $product_id = intval($_GET['id']);
        $quantity = 1; 
        
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        if ($product) {
            $stmt = $pdo->prepare("SELECT id FROM cart WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $existing = $stmt->fetch();
            if ($existing) {
                $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ?");
                $stmt->execute([$product_id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO cart (product_id, quantity) VALUES (?, ?)");
                $stmt->execute([$product_id, $quantity]);
            }
            header("Location: cart.php");
            exit;
        } else {
            header("Location: catalogo.php?error=producto_no_existe");
            exit;
        }
    } 
    else {
        header("Location: catalogo.php?error=id_invalido");
        exit;
    }
