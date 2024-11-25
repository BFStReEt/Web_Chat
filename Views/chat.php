<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Chat</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>WebSocket Chat Room</h2>
    <div id="chat-box"></div>
    <div style="margin-top: 10px;">
        <input type="text" id="username" placeholder="Tên của bạn">
        <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
        <button id="send-btn">Gửi</button>
    </div>

    <script src="chat-client.js"></script>
</body>

</html>
