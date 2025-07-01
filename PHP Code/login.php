<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require_once "database.php";

$pdo = connectDB();
$email = $password = "";
$email_err = $password_err = $login_err = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profile.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Enter your email";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT student_id, first_name, email, password FROM students WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $student_id = $row["student_id"];
                    $first_name = $row["first_name"];
                    $hashed_password = $row["password"];

                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["student_id"] = $student_id;
                        $_SESSION["email"] = $email;
                        $_SESSION["first_name"] = $first_name;

                        header("location: profile.php");
                        exit;
                    } else {
                        $login_err = "Invalid email or password.";
                    }
                } else {
                    $login_err = "No account found with that email.";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
            }
        }
    }
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
    <title>Student Login</title>
</head>
<body>
<?php require 'index.php'; ?>

<div class="container text-center">
    <h1>Student Login</h1>
    <p>Please enter your credentials to log in.</p>
</div>

<div class="container" style="max-width: 600px;">
    <?php if (!empty($login_err)): ?>
        <div class="alert alert-danger"><?php echo $login_err; ?></div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>" required>
            <span class="text-danger"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
            <span class="text-danger"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-lg">Login</button>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>
</body>
</html>

<?php 
//references
//https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
//https://www.php.net/manual/en/function.password-hash.php
//https://www.php.net/manual/en/function.password-verify.php
//https://www.php.net/manual/en/function.session-start.php
?>
</html>
