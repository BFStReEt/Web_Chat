<?
    $host = 'localhost';
    $db_name = 'chat_app';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host,$username,$password,$db_name);
    if($conn->connect_error){
        die("Kết nối thất bại: ",$conn->connect_error);
    }
?>