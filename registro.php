<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja_virtual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO Usuario (nome, email, senha, endereco) VALUES ('$nome', '$email', '$senha', '$endereco')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['usuario_id'] = $conn->insert_id;
        header('Location: index.php');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Harmonia Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Harmonia Shop</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
    </nav>
    <div class="container">
        <h2>Registrar</h2>
        <form action="registro.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>
            <input type="submit" value="Registrar">
        </form>
    </div>
    <div class="footer">
        <p>Harmonia Shop &copy; 2024</p>
    </div>
</body>
</html>
