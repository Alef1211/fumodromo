<?php
// Incluir arquivo de configuração do banco de dados
require_once '../config/database.php';
session_start();

// Receber dados do formulário
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Validar dados
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos']);
    exit;
}

try {
    // Buscar usuário no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verificar se o usuário existe e a senha está correta
    if ($user && password_verify($password, $user['password'])) {
        // Criar sessão do usuário
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];        // Converter a data para UTC e formato ISO 8601
        $quit_date = new DateTime($user['quit_date'], new DateTimeZone('UTC'));
        $quit_date_iso = $quit_date->format('Y-m-d\TH:i:s\Z');
        
        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'quit_date' => $quit_date_iso,
                'cigarettes_per_day' => $user['cigarettes_per_day'],
                'pack_price' => $user['pack_price']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário ou senha incorretos']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao fazer login']);
}
?>
