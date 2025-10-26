<?php 
include '../config.php';
include '../classes/Course.php';
include '../classes/Review.php';

$course = new Course($db);
$review = new Review($db);

$courses = $course->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все курсы</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Все курсы</h2>
        
        <?php while($course_row = mysqli_fetch_assoc($courses)): ?>
        <div class="course-block">
            <h3><?php echo $course_row['name']; ?></h3>
            <p><strong>Преподаватель:</strong> <?php echo $course_row['teacher_name']; ?></p>
            <p><strong>Описание:</strong> <?php echo $course_row['description']; ?></p>
            <p><strong>Продолжительность:</strong> <?php echo $course_row['duration_hours']; ?> часов</p>
            <p><strong>Цена:</strong> <?php echo $course_row['price']; ?> руб.</p>
            
            <h4>Отзывы о курсе:</h4>
            <?php
            $reviews = $review->getCourseReviews($course_row['id']);
            if (mysqli_num_rows($reviews) > 0): ?>
                <?php while($review_row = mysqli_fetch_assoc($reviews)): ?>
                <div class="review-item">
                    <p><strong><?php echo $review_row['full_name']; ?></strong> 
                    (Оценка: <?php echo $review_row['rating']; ?>/5)</p>
                    <p><?php echo $review_row['comment']; ?></p>
                    <small><?php echo $review_row['created_at']; ?></small>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Пока нет отзывов</p>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
        
        <p><a href="../index.php">На главную</a></p>
    </div>
</body>
</html>