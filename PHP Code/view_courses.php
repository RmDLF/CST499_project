<?php
require 'database.php';
require 'index.php';

$pdo = connectDB();
$stmt = $pdo->query("SELECT course_id, course_name, seat_limit, seat_available FROM coursetable");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Courses</title>
</head>
<body>

<div class="container text-center">
    <h2>Fall 2025 Courses</h2>
</div>

<div class="container">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="info text-center">
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Seat Limit</th>
                <th>Seats Available</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= htmlspecialchars($course['course_id']) ?></td>
                    <td><?= htmlspecialchars($course['course_name']) ?></td>
                    <td><?= $course['seat_limit'] ?></td>
                    <td><?= $course['seat_available'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="profile.php" class="btn btn-primary">Back to Profile</a>
    </div>
</div>

<?php require 'footer.php'; ?>
</body>
</html>
