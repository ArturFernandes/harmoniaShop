<?php
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

// Processar dados do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM Usuario WHERE email='$email' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Iniciar a sessão e redirecionar para a página principal
        session_start();
        $_SESSION['email'] = $email;
        header("Location: index.php");
    } else {
        echo "E-mail ou senha incorretos.";
    }
}

// Fechar conexão
$conn->close();
?>
