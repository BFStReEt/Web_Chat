<?php
namespace App\Models;

class ChatModel
{
    protected $messages = [];

    public function saveMessage($username, $message)
    {
        $this->messages[] = [
            'username' => $username,
            'message' => $message,
            'time' => date('H:i:s'),
        ];
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
