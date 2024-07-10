<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja_virtual";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM usuario WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Erro ao recuperar informações do perfil.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Harmonia Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Perfil de Usuário</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Informações do Perfil</h2>
        <p><strong>Nome:</strong> <?php echo $user['nome']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Endereço:</strong> <?php echo $user['endereco']; ?></p>
    </div>
    <div class="footer">
        <p>Harmonia Shop &copy; 2024</p>
    </div>
</body>
</html>
