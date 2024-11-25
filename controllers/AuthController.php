<?php
require_once('../config/database.php');

class AuthController {
    
    // Đăng ký người dùng
    public function register($username, $password) {
        global $conn;

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "Tài khoản đã tồn tại.";
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo "Đăng ký thành công!";
        } else {
            echo "Lỗi đăng ký!";
        }
    }

    // Đăng nhập người dùng
    public function login($username, $password) {
        global $conn;

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: /chat-app/views/chat/chatroom.php");
                exit;
            } else {
                echo "Sai mật khẩu.";
            }
        } else {
            echo "Tài khoản không tồn tại.";
        }
    }
}

// Kiểm tra đăng ký hoặc đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($action == 'register') {
            $authController->register($username, $password);
        } elseif ($action == 'login') {
            $authController->login($username, $password);
        }
    }
}
?>
