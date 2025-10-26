<?php 
include '../config.php';
include '../classes/User.php';

$user = new User($db);

if ($_POST) {
    $user->login = $_POST['login'];
    $user->password = md5($_POST['password']);
    
    if ($user->login()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['admin'] = ($user->role_id == 0);
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Вход</h2>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="text" name="login" placeholder="Логин" required><br><br>
            <input type="password" name="password" placeholder="Пароль" required><br><br>
            <button type="submit">Войти</button>
        </form>
        
        <p><a href="register.php">Нет аккаунта? Зарегистрироваться</a></p>
        <p><a href="../index.php">На главную</a></p>
    </div>
</body>
</html>