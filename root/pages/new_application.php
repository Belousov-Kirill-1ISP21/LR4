<?php 
include '../config.php';
include '../classes/Application.php';
include '../classes/Course.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin']) {
    header("Location: ../index.php");
    exit;
}

$course = new Course($db);
$courses = $course->getAll();

$application = new Application($db);

if ($_POST) {
    $application->user_id = $_SESSION['user_id'];
    $application->course_id = $_POST['course_id'];
    $application->start_date = $_POST['start_date'];
    $application->payment_method = $_POST['payment_method'];
    $application->status_id = 1; 
    
    if ($application->create()) {
        $success = "Заявка отправлена!";
    } else {
        $error = "Ошибка при создании заявки";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Новая заявка на курс</h2>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        
        <form method="POST">
            <select name="course_id" required>
                <option value="">Выберите курс</option>
                <?php
                while($course_row = mysqli_fetch_assoc($courses)) {
                    echo "<option value='{$course_row['id']}'>{$course_row['name']} - {$course_row['price']} руб.</option>";
                }
                ?>
            </select><br><br>
            
            <input type="date" name="start_date" required><br><br>
            <select name="payment_method" required>
                <option value="cash">Наличные</option>
                <option value="transfer">Перевод по номеру телефона</option>
            </select><br><br>
            <button type="submit">Отправить заявку</button>
        </form>
        
        <p><a href="my_applications.php">Мои заявки</a></p>
        <p><a href="courses.php">Все курсы</a></p>
        <p><a href="../index.php">На главную</a></p>
    </div>
</body>
</html>