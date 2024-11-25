<?php
use App\Controllers\ChatController;

$chatController = new ChatController();

// Route để lấy lịch sử chat
if ($_SERVER['REQUEST_URI'] === '/chat-history') {
    header('Content-Type: application/json');
    echo json_encode($chatController->getChatHistory());
}

// Route để gửi tin nhắn
if ($_SERVER['REQUEST_URI'] === '/send-message' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'] ?? 'Anonymous';
    $message = $data['message'] ?? '';

    header('Content-Type: application/json');
    echo json_encode($chatController->sendMessage($username, $message));
}
