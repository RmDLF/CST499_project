<?php
session_start();
require 'database.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$pdo = connectDB();
$student_id = $_SESSION['student_id'];

// Handle unenrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drop_course_id'])) {
    $drop_course_id = $_POST['drop_course_id'];

    // Delete the course enrollment
    $delete = $pdo->prepare("DELETE FROM student_courses WHERE student_id = :student_id AND course_id = :course_id");
    $delete->execute([
        ':student_id' => $student_id,
        ':course_id' => $drop_course_id
    ]);

    // Increment available seat
    $update = $pdo->prepare("UPDATE coursetable SET seat_available = seat_available + 1 WHERE course_id = :course_id");
    $update->execute([':course_id' => $drop_course_id]);

    // Refresh the page
    header("Location: schedule.php");
    exit;
}

// Fetch enrolled courses
$sql = "SELECT c.course_id, c.course_name
        FROM student_courses sc
        JOIN coursetable c ON sc.course_id = c.course_id
        WHERE sc.student_id = :student_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
$stmt->execute();
$enrolled_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>My Schedule</title>
</head>
<body>

<?php require 'main.php'; ?>

<div class="container text-center">
    <h1>My Schedule</h1>
</div>

<div class="container">
    <?php if (count($enrolled_courses) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolled_courses as $course): ?>
                    <tr>
                        <td><?= htmlspecialchars($course['course_id']) ?></td>
                        <td><?= htmlspecialchars($course['course_name']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="drop_course_id" value="<?= htmlspecialchars($course['course_id']) ?>">
                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to unenroll from this course?');">UNENROLL</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">
            You are not enrolled in any courses yet.
        </div>
    <?php endif; ?>
    <div class="text-center">
        <a href="profile.php" class="btn btn-default">Back to Profile</a>
    </div>
</div>

<?php require 'footer.php'; ?>
</body>
</html>

