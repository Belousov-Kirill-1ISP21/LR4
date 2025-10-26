<?php 
include '../config.php';
include '../classes/User.php';

$user = new User($db);

if ($_POST) {
    $user->login = $_POST['login'];
    $user->password = md5($_POST['password']);
    $user->full_name = $_POST['full_name'];
    $user->phone = $_POST['phone'];
    $user->email = $_POST['email'];
    $user->role_id = 1;
    
    if ($user->register()) {
        $success = "Регистрация успешна!";
    } else {
        $error_message = $user->error;
        
        if (strpos($error_message, 'login') !== false) {
            $error = "Логин уже занят";
        } elseif (strpos($error_message, 'email') !== false) {
            $error = "Email уже занят";
        } elseif (strpos($error_message, 'phone') !== false) {
            $error = "Телефон уже занят";
        } else {
            $error = "Ошибка регистрации: " . $error_message;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Регистрация</h2>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        
        <form method="POST">
            <input type="text" name="login" placeholder="Логин" required><br><br>
            <input type="password" name="password" placeholder="Пароль" required><br><br>
            <input type="text" name="full_name" placeholder="ФИО" required><br><br>
            <input type="text" name="phone" placeholder="Телефон" required><br><br>
            <input type="email" name="email" placeholder="Email" required><br><br>
            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <p><a href="login.php">Уже есть аккаунт? Войти</a></p>
        <p><a href="../index.php">На главную</a></p>
    </div>
</body>
</html>