<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$produto_id = $_POST['produto_id'];

// Arquivo de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja_virtual";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$email = $_SESSION['email'];

// Consultar usuário
$sql = "SELECT id FROM Usuario WHERE email='$email'";
$result = $conn->query($sql);
$user_id = $result->fetch_assoc()['id'];

// Verificar se o usuário já tem um pedido aberto (carrinho)
$sql = "SELECT id FROM Pedido WHERE usuario_id='$user_id' AND status='aberto'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Se o pedido já existe, obter o ID do pedido
    $pedido_id = $result->fetch_assoc()['id'];
} else {
    // Se o pedido não existe, criar um novo pedido
    $sql = "INSERT INTO Pedido (usuario_id, status) VALUES ('$user_id', 'aberto')";
    $conn->query($sql);
    $pedido_id = $conn->insert_id;
}

// Consultar o preço do produto
$sql = "SELECT preco FROM Produto WHERE id='$produto_id'";
$result = $conn->query($sql);
$produto_preco = $result->fetch_assoc()['preco'];

// Verificar se o produto já está no pedido
$sql = "SELECT * FROM ItemPedido WHERE pedido_id='$pedido_id' AND produto_id='$produto_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Se o produto já está no pedido, aumentar a quantidade
    $sql = "UPDATE ItemPedido SET quantidade = quantidade + 1 WHERE pedido_id='$pedido_id' AND produto_id='$produto_id'";
} else {
    // Se o produto não está no pedido, adicionar novo item
    $sql = "INSERT INTO ItemPedido (pedido_id, produto_id, quantidade, preco) VALUES ('$pedido_id', '$produto_id', 1, '$produto_preco')";
}

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Erro ao adicionar ao carrinho: " . $conn->error;
}

// Fechar conexão
$conn->close();
?>
