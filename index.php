<?php
session_start();
$isLoggedIn = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruydo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bem-vindo à Ruydo</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <?php if (!$isLoggedIn): ?>
            <a href="login.html">Login</a>
            <a href="registro.html">Registrar</a>
        <?php else: ?>
            <a href="perfil.php">Perfil</a>
        <?php endif; ?>
        <a href="carrinho.php">Carrinho</a>
    </nav>
    <div class="container">
        <h2>Catálogo de Produtos</h2>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <p class="success">Produto adicionado ao carrinho com sucesso!</p>
        <?php endif; ?>

        <?php
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

        $sql = "SELECT * FROM produto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="produto">';
                echo '<a href="produto_detalhes.php?id=' . $row["id"] . '">';
                echo '<img src="' . $row["imagem_url"] . '" alt="' . $row["nome"] . '" class="imagem_produto">';
                echo '<p>Nome: ' . $row["nome"] . ' - Descrição: ' . $row["descricao"] . ' - Preço: ' . $row["preco"] . '</p>';
                echo '</a>';
                echo '<form method="post" action="adicionar_carrinho.php">';
                echo '<input type="hidden" name="produto_id" value="' . $row["id"] . '">';
                echo '<button type="submit">Adicionar ao Carrinho</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "Nenhum produto encontrado.";
        }

        $conn->close();
        ?>
    </div>
    <div class="footer">
        <p>Ruydo &copy; 2024</p>
    </div>
</body>
</html>
