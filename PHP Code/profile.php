<?php
error_reporting(E_ALL ^ E_NOTICE);
require 'database.php';
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$pdo = connectDB(); 

// Fetch user data
$sql = "SELECT first_name, last_name, phone, email, student_id FROM students WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":email", $_SESSION["email"], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
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

<?php require 'main.php'; ?>

<div class="container text-center">
    <h1>Welcome to the Student Portal</h1>
    <h2>Hello <?php echo htmlspecialchars($user["first_name"]); ?>!</h2>
    <p>You are logged in and your profile details are below:</p>
</div>

<div class="container">
    <h3>Your Information</h3>
    <table class="table table-striped">
        <tr><th>First Name</th><td><?php echo htmlspecialchars($user['first_name']); ?></td></tr>
        <tr><th>Last Name</th><td><?php echo htmlspecialchars($user['last_name']); ?></td></tr>
        <tr><th>Student ID</th><td><?php echo htmlspecialchars($user['student_id']); ?></td></tr>
        <tr><th>Email</th><td><?php echo htmlspecialchars($user['email']); ?></td></tr>
        <tr><th>Phone</th><td><?php echo htmlspecialchars($user['phone']); ?></td></tr>
     </table>
</div>
<div class="text-center">
    <a href="view_courses.php" class="btn btn-info">Available Classes</a>
    <a href="enrollment.php" class="btn btn-success">Enroll</a>
    <a href="schedule.php" class="btn btn-primary">View My Schedule</a>
</div>



<?php require 'footer.php'; ?>
</body>
</html>