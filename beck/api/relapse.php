<?php
// Incluir arquivo de configuração do banco de dados
require_once '../config/database.php';
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não está logado']);
    exit;
}

try {
    // Data atual como nova data de recaída em UTC
    $relapseDate = new DateTime('now', new DateTimeZone('UTC'));
    $relapseDateStr = $relapseDate->format('Y-m-d H:i:s');
    
    // Registrar a recaída
    $stmt = $pdo->prepare("
        INSERT INTO relapses (user_id, relapse_date)
        VALUES (?, ?)
    ");    $stmt->execute([$_SESSION['user_id'], $relapseDateStr]);

    // Atualizar a data de parada na tabela de usuários
    $stmt = $pdo->prepare("
        UPDATE users 
        SET quit_date = ? 
        WHERE id = ?
    ");
    $stmt->execute([$relapseDateStr, $_SESSION['user_id']]);
    
    // Retornar a data em UTC e formato ISO 8601
    $quit_date_iso = $relapseDate->format('Y-m-d\TH:i:s\Z');
    
    echo json_encode([
        'success' => true,
        'message' => 'Recaída registrada',
        'new_quit_date' => $quit_date_iso
    ]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao registrar recaída']);
}
?>
