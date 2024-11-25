<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../assets/css/style.css"> <!-- Đường dẫn đến file CSS -->
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <form action="../../controllers/AuthController.php" method="POST" class="register-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="action" value="register" class="register-button">Register</button>
        </form>
    </div>
</body>
</html>
