<?php 
include '../config.php';
include '../classes/Application.php';
include '../classes/Review.php';
include '../classes/Course.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin']) {
    header("Location: ../index.php");
    exit;
}

$application = new Application($db);
$review = new Review($db);
$course = new Course($db);

if ($_POST && isset($_POST['rating'])) {
    $review->user_id = $_SESSION['user_id'];
    $review->course_id = $_POST['course_id'];
    $review->rating = $_POST['rating'];
    $review->comment = $_POST['comment'];
    
    if ($review->create()) {
        $success = "Отзыв добавлен!";
    } else {
        $error = "Ошибка при добавлении отзыва";
    }
}

$applications = $application->getUserApplications($_SESSION['user_id']);
$courses = $course->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Мои заявки</h2>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        
        <h3>Мои заявки на курсы</h3>
        <?php
        if (mysqli_num_rows($applications) > 0): ?>
            <table>
                <tr>
                    <th>Курс</th>
                    <th>Преподаватель</th>
                    <th>Цена</th>
                    <th>Дата начала</th>
                    <th>Статус</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($applications)): ?>
                <tr>
                    <td><?php echo $row['course_name']; ?></td>
                    <td><?php echo $row['teacher_name']; ?></td>
                    <td><?php echo $row['price']; ?> руб.</td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['status_name']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>У вас нет заявок</p>
        <?php endif; ?>
        
        <h3>Оставить отзыв о курсе</h3>
        <form method="POST">
            <select name="course_id" required>
                <option value="">Выберите курс</option>
                <?php
                mysqli_data_seek($courses, 0);
                while($course_row = mysqli_fetch_assoc($courses)) {
                    echo "<option value='{$course_row['id']}'>{$course_row['name']}</option>";
                }
                ?>
            </select><br><br>
            <select name="rating" required>
                <option value="5">5 - Отлично</option>
                <option value="4">4 - Хорошо</option>
                <option value="3">3 - Нормально</option>
                <option value="2">2 - Плохо</option>
                <option value="1">1 - Ужасно</option>
            </select><br><br>
            <textarea name="comment" placeholder="Ваш отзыв о курсе" rows="4" cols="50"></textarea><br><br>
            <button type="submit">Отправить отзыв</button>
        </form>
        
        <p><a href="new_application.php">Оставить новую заявку</a></p>
        <p><a href="courses.php">Все курсы</a></p>
        <p><a href="../index.php">На главную</a></p>
    </div>
</body>
</html>