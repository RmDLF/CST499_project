<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Registration Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<div class="jumbotron text-center">
        <h1>Welcome to the Student Course Registration Portal</h1>
</div>
<div class="container text-center">
        <h2>This portal allows students to register for courses, manage their profile, and stay informed.</h2>
</div>
<div class="text-center">
        <h3> If your are new to the portal please register before, if you are already registered please login to manage your courses.
        <h3>
            <a href="login.php" class="btn btn-primary btn-lg">Login</a>
            <a href="registration.php" class="btn btn-success btn-lg">Register</a>
        </p>
    
</div>

<?php include 'footer.php'; ?>

</body>
</html>
