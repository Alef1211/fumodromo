<?php
// Arquivo de configuração da conexão com o banco de dados
$host = 'localhost';      // Servidor MySQL
$dbname = 'quit_smoking'; // Nome do banco de dados
$username = 'root';       // Usuário do MySQL (padrão do XAMPP)
$password = '';          // Senha (padrão do XAMPP é vazia)

try {
    // Criando a conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurando o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurando o modo de busca padrão como array associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Em caso de erro na conexão, exibe a mensagem
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
