<?php
namespace App\Controllers;

use App\Models\ChatModel;

class ChatController
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function sendMessage($username, $message)
    {
        $this->chatModel->saveMessage($username, $message);
        return $this->chatModel->getMessages();
    }

    public function getChatHistory()
    {
        return $this->chatModel->getMessages();
    }
}
