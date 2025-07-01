<?php
error_reporting(E_ALL ^ E_NOTICE);
require 'database.php';
session_start();

$pdo = connectDB();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student = [
        'studentId' => generateStudentId($pdo),
        'firstName' => $_POST['firstName'] ?? '',
        'lastName'  => $_POST['lastName'] ?? '',
        'phone'     => $_POST['phone'] ?? '',
        'email'     => $_POST['email'] ?? '',
        'password'  => $_POST['password'] ?? '',
    ];

    $message = executeQuery($pdo, $student);
}
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
    <title>Student Registration</title>
</head>
<body>

<?php require 'index.php'; ?>

<div class="container text-center">
    <h1>Student Registration</h1><br>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
</div>

<form method="POST" action="registration.php">
    <div class="container">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="form-group col-md-6">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
              <div class="form-group col-md-6">
                <label for="password">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg">Register</button>
            </div>
        </div>
    </div>
</form>
<script>
    document.querySelector("form").addEventListener("submit", function (e) {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (password !== confirmPassword) {
            e.preventDefault(); // Stop form from submitting
            alert("Passwords do not match.");
        }
    });
</script>

<?php require 'footer.php'; ?>
</body>
</html>
