<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// Lưu trữ lịch sử chat
$chatHistory = [];

class ChatServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage; // Lưu trữ kết nối của các client
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Khi một client mới kết nối
        $this->clients->attach($conn);
        echo "Kết nối mới: {$conn->resourceId}\n";

        // Gửi lịch sử chat cho client mới kết nối
        global $chatHistory;
        foreach ($chatHistory as $messageData) {
            $conn->send(json_encode($messageData));
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Khi nhận được tin nhắn từ một client
        echo "Tin nhắn từ {$from->resourceId}: $msg\n";

        $messageData = json_decode($msg, true);

        // Lưu lịch sử tin nhắn
        global $chatHistory;
        $chatHistory[] = $messageData;

        // Gửi tin nhắn tới tất cả các client khác
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Khi một client đóng kết nối
        $this->clients->detach($conn);
        echo "Kết nối đã đóng: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        // Khi xảy ra lỗi
        echo "Lỗi: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Tạo WebSocket Server
$port = 9000;
$server = \Ratchet\Server\IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\WebSocket\WsServer(
            new ChatServer()
        )
    ),
    $port
);

echo "WebSocket server đang chạy tại ws://localhost:$port\n";
$server->run();