<?php
// Incluir arquivo de configuração do banco de dados
require_once '../config/database.php';

// Receber dados do formulário
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$cigarettes = $data['cigarettes'] ?? 0;
$packPrice = $data['pack-price'] ?? 0;

// Validar dados
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
    exit;
}

try {
    // Verificar se o usuário já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Usuário ou e-mail já cadastrado']);
        exit;
    }

    // Hash da senha
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);    // Data atual como data de início para parar de fumar em UTC
    $quitDate = new DateTime('now', new DateTimeZone('UTC'));
    $quitDateStr = $quitDate->format('Y-m-d H:i:s');// Usar GMT/UTC

    // Inserir novo usuário
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password, quit_date, cigarettes_per_day, pack_price)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$username, $email, $hashedPassword, $quitDateStr, $cigarettes, $packPrice]);

    echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso']);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao realizar cadastro']);
}
?>
