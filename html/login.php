<?php
include 'includes/db.php';
session_start();

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/login.css"/>
</head>
<body >
    <div class="container">
        <h2>Iniciar Sesión</h2>
    <form method="POST">
        <input name="username" class="form-control" placeholder="Usuario" required><br>
        <input name="password" type="password" class="form-control" placeholder="Contraseña" required><br>
        <button class="btn btn-primary">Entrar</button>
    </form>
</div>
    
 
</body>
</html>
