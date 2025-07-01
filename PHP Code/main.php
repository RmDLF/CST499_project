<?php
error_reporting(E_ALL ^ E_NOTICE);
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
    <title>Student Portal</title>
</head>
<body>
<?php require 'index.php';?>
  <div class="container text-center">

    <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
        <div class="alert alert-success" role="alert">
            You have successfully logged out.
        </div>
    <?php endif; ?>
</div>

    <?php require 'footer.php';?>
    <?php 
    //Reference:
    //https://getbootstrap.com/docs/4.0/components/alerts/
    //https://www.sitepoint.com/community/t/displaying-logout-notice/22651/2
    ?>
</body>
</html> 