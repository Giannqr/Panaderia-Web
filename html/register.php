<?php
include 'includes/db.php';

if ($_POST) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        header('Location: login.php');
    } else {
        echo "Error al registrar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../css/crud.css">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Registro de Usuario</h2>
    <form method="POST">
        <input name="username" class="form-control" placeholder="Usuario" required><br>
        <input name="password" type="password" class="form-control" placeholder="Contraseña" required><br>
        <button class="btn btn-primary">Registrar</button>
    </form>
    <a href="login.php">Iniciar sesión</a>
</body>
</html>
