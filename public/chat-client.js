const socket = new WebSocket('ws://192.168.100.139:9000');

const chatBox = document.getElementById('chat-box');
const usernameInput = document.getElementById('username');
const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-btn');

// Kết nối WebSocket
socket.addEventListener('open', () => {
    console.log('Đã kết nối tới WebSocket server.');
});

// Nhận tin nhắn từ server
socket.addEventListener('message', (event) => {
    const data = JSON.parse(event.data);
    const message = document.createElement('p');
    message.textContent = `[${data.time}] ${data.username}: ${data.message}`;
    chatBox.appendChild(message);
    chatBox.scrollTop = chatBox.scrollHeight;
});

// Gửi tin nhắn
sendButton.addEventListener('click', () => {
    const username = usernameInput.value.trim();
    const message = messageInput.value.trim();

    if (!username || !message) return;

    socket.send(JSON.stringify({ username, message }));
    messageInput.value = '';
});
