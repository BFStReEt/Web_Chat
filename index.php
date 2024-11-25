<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        #chat-box {
            width: 80%;
            height: 400px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow-y: auto;
            padding: 10px;
            background-color: #fff;
        }

        #message-input {
            width: calc(80% - 120px);
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #send-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }

        #send-btn:hover {
            background-color: #0056b3;
        }

        #name-input {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 80%;
        }
    </style>
</head>

<body>
    <h2>WebSocket Chat Room</h2>

    <!-- Nhập tên người dùng -->
    <input type="text" id="name-input" placeholder="Nhập tên của bạn" />

    <div id="chat-box"></div>

    <div style="margin-top: 10px;">
        <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
        <button id="send-btn">Gửi</button>
    </div>

    <script>
        let username = "";

        // Lấy tên người dùng từ input
        document.getElementById('name-input').addEventListener('input', function () {
            username = this.value;
        });

        // Kết nối tới WebSocket server
        const socket = new WebSocket('ws://192.168.100.139:9000');

        const chatBox = document.getElementById('chat-box');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-btn');

        // Khi kết nối thành công
        socket.addEventListener('open', function () {
            console.log('Đã kết nối tới WebSocket server.');
        });

        // Xử lý tin nhắn nhận được từ server
        socket.addEventListener('message', function (event) {
            const messageData = JSON.parse(event.data);
            const messageElement = document.createElement('p');
            messageElement.innerHTML = `<strong>${messageData.username}:</strong> ${messageData.message}`;
            chatBox.appendChild(messageElement);

            // Tự động cuộn xuống cuối chatbox
            chatBox.scrollTop = chatBox.scrollHeight;
        });

        // Xử lý khi nút gửi được bấm
        sendButton.addEventListener('click', function () {
            const message = messageInput.value.trim();
            if (message === '') return;

            // Hiển thị tin nhắn của bạn ngay lập tức
            const messageData = {
                username: username || "Người dùng ẩn danh",  // Nếu không có tên, hiển thị "Người dùng ẩn danh"
                message: message
            };

            // Hiển thị tin nhắn của bạn trong khung chat
            const messageElement = document.createElement('p');
            messageElement.innerHTML = `<strong>${messageData.username}:</strong> ${messageData.message}`;
            chatBox.appendChild(messageElement);

            // Tự động cuộn xuống cuối chatbox
            chatBox.scrollTop = chatBox.scrollHeight;

            // Gửi tin nhắn tới server
            socket.send(JSON.stringify(messageData));
            messageInput.value = '';
        });

        // Xử lý khi nhấn phím Enter
        messageInput.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                sendButton.click();
            }
        });

        // Khi kết nối bị đóng
        socket.addEventListener('close', function () {
            console.log('Kết nối WebSocket đã bị đóng.');
            const errorMessage = document.createElement('p');
            errorMessage.textContent = 'Mất kết nối tới server.';
            errorMessage.style.color = 'red';
            chatBox.appendChild(errorMessage);
        });

    </script>
</body>

</html>