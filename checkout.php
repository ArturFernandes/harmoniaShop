<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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

// Consultar o pedido aberto do usuário
$sql = "SELECT * FROM Pedido WHERE usuario_id='$user_id' AND status='aberto'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $pedido_id = $result->fetch_assoc()['id'];

    // Atualizar o status do pedido para 'concluido'
    $sql = "UPDATE Pedido SET status='concluido' WHERE id='$pedido_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: sucesso.php");
    } else {
        echo "Erro ao finalizar a compra: " . $conn->error;
    }
} else {
    echo "Seu carrinho está vazio.";
}

// Fechar conexão
$conn->close();
?>
