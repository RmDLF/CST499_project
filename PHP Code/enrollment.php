<?php
session_start();
require 'database.php'; 

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = connectDB();
$student_id = $_SESSION['student_id'];
$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    
    $check = $pdo->prepare("SELECT * FROM student_courses WHERE student_id = ? AND course_id = ?");
    $check->execute([$student_id, $course_id]);

    if ($check->rowCount() == 0) {
       
        $insert = $pdo->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");
        $insert->execute([$student_id, $course_id]);

     
        $update = $pdo->prepare("UPDATE coursetable SET seat_available = seat_available - 1 WHERE course_id = ? AND seat_available > 0");
        $update->execute([$course_id]);

        $message = "Enrollment successful!";
    } else {
        $message = "You are already enrolled in this course.";
    }
}

// Get all available courses
$stmt = $pdo->query("SELECT * FROM coursetable WHERE seat_available > 0");
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
</head>
<body>
<?php require 'index.php'; ?>

<div class="container">
    <h2 class="text-center">Enroll in a Course</h2>
    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" class="form-horizontal">
        <div class="form-group">
            <label for="course_id" class="col-sm-2 control-label">Available Courses</label>
            <div class="col-sm-8">
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="" disabled selected>Select a course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= htmlspecialchars($course['course_id']) ?>">
                            <?= htmlspecialchars($course['course_name']) ?> (<?= $course['seat_available'] ?> seats left)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success">Enroll</button>
            </div>
        </div>
    </form>

    <div class="text-center">
        <a href="profile.php" class="btn btn-default">Back to Profile</a>
    </div>
</div>

</body>
</html>

