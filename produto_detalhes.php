<?php
session_start();

// Verificar se o ID do produto foi passado pela URL
if (!isset($_GET['id'])) {
    die("Produto não encontrado.");
}

$produto_id = $_GET['id'];

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

// Buscar detalhes do produto
$sql = "SELECT * FROM produto WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $produto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Produto não encontrado.");
}

$produto = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto - Ruydo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Detalhes do Produto</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <?php if (!isset($_SESSION['email'])): ?>
            <a href="login.html">Login</a>
            <a href="registro.html">Registrar</a>
        <?php else: ?>
            <a href="perfil.php">Perfil</a>
        <?php endif; ?>
        <a href="carrinho.php">Carrinho</a>
    </nav>
    <div class="container">
        <div class="produto-detalhe">
            <img src="<?php echo $produto['imagem_url']; ?>" alt="<?php echo $produto['nome']; ?>" class="imagem_produto_detalhe">
            <h2><?php echo $produto['nome']; ?></h2>
            <p><strong>Descrição:</strong> <?php echo $produto['descricao']; ?></p>
            <p><strong>Preço:</strong> R$ <?php echo $produto['preco']; ?></p>
            <form method="post" action="adicionar_carrinho.php">
                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                <button type="submit">Adicionar ao Carrinho</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>Ruydo &copy; 2024</p>
    </div>
</body>
</html>
