<?php
// controllers/AdminController.php
include '../config/database.php';

class AdminController {
    public function blockUser($user_id) {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET status = 'blocked' WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function deleteUser($user_id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function editUser($user_id, $username, $role) {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $role, $user_id);
        return $stmt->execute();
    }
}

// Dùng AdminController
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin = new AdminController();

    if ($_POST['action'] === 'block') {
        $admin->blockUser($_POST['user_id']);
        header("Location: ../views/admin/dashboard.php");
    }

    if ($_POST['action'] === 'delete') {
        $admin->deleteUser($_POST['user_id']);
        header("Location: ../views/admin/dashboard.php");
    }

    if ($_POST['action'] === 'edit') {
        $admin->editUser($_POST['user_id'], $_POST['username'], $_POST['role']);
        header("Location: ../views/admin/dashboard.php");
    }
}
