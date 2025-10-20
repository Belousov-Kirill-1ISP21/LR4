<?php 
include '../config.php';
include '../classes/Application.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: ../index.php");
    exit;
}

$application = new Application($db);

if ($_POST && isset($_POST['application_id'])) {
    $application->id = $_POST['application_id'];
    $application->status = $_POST['status'];
    
    if ($application->updateStatus()) {
        $success = "Статус обновлен!";
    } else {
        $error = "Ошибка при обновлении статуса";
    }
}

$applications = $application->getAllApplications();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Панель администратора</h2>
        
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        
        <h3>Все заявки</h3>
        <?php
        if (mysqli_num_rows($applications) > 0): ?>
            <table>
                <tr>
                    <th>Пользователь</th>
                    <th>Курс</th>
                    <th>Преподаватель</th>
                    <th>Дата начала</th>
                    <th>Способ оплаты</th>
                    <th>Статус</th>
                    <th>Дата подачи</th>
                    <th>Изменить статус</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($applications)): ?>
                <tr>
                    <td><?php echo $row['full_name'] . ' (' . $row['login'] . ')'; ?></td>
                    <td><?php echo $row['course_name']; ?></td>
                    <td><?php echo $row['teacher_name'] ?: 'Не назначен'; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['payment_method'] == 'cash' ? 'Наличные' : 'Перевод'; ?></td>
                    <td>
                        <?php 
                        $statuses = [
                            'new' => 'Новая', 
                            'in_progress' => 'Идет обучение', 
                            'completed' => 'Завершено'
                        ];
                        echo $statuses[$row['status']];
                        ?>
                    </td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="new" <?php echo $row['status'] == 'new' ? 'selected' : ''; ?>>Новая</option>
                                <option value="in_progress" <?php echo $row['status'] == 'in_progress' ? 'selected' : ''; ?>>Идет обучение</option>
                                <option value="completed" <?php echo $row['status'] == 'completed' ? 'selected' : ''; ?>>Завершено</option>
                            </select>
                            <button type="submit">Обновить</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Нет заявок</p>
        <?php endif; ?>
        
        <p><a href="../index.php">На главную</a></p>
    </div>
</body>
</html>