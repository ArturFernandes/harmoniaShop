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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Harmonia Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Carrinho de Compras</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="perfil.php">Perfil</a>
    </nav>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            $pedido_id = $result->fetch_assoc()['id'];

            // Consultar os itens do pedido
            $sql = "SELECT ip.*, p.nome, p.descricao FROM ItemPedido ip JOIN Produto p ON ip.produto_id = p.id WHERE ip.pedido_id='$pedido_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Seu Carrinho</h2>";
                echo "<table>";
                echo "<tr><th>Produto</th><th>Descrição</th><th>Quantidade</th><th>Preço</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nome"] . "</td>";
                    echo "<td>" . $row["descricao"] . "</td>";
                    echo "<td>" . $row["quantidade"] . "</td>";
                    echo "<td>R$ " . $row["preco"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<form action='checkout.php' method='post'>";
                echo "<input type='submit' value='Finalizar Compra'>";
                echo "</form>";
            } else {
                echo "Seu carrinho está vazio.";
            }
        } else {
            echo "Seu carrinho está vazio.";
        }

        // Fechar conexão
        $conn->close();
        ?>
    </div>
    <div class="footer">
        <p>Harmonia Shop &copy; 2024</p>
    </div>
</body>
</html>
