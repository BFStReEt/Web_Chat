<?php
include './config/database.php';
include './app/Views/login.php'

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (?,?)");
    $stmt->bind_param("ss",$username,$password);

    if($stmt->execute()){
        header("Location: ./Views/login.php");
    }
    else{
        echo "Lỗi: ".$stmt->error;
    }
}
?>