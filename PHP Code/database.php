<?php
function connectDB() {
    try {
        $connString = "mysql:host=localhost;dbname=cst499";
        $user = "root";
        $pass = "";
        $pdo = new PDO($connString, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function generateStudentId($pdo) {
    do {
        $id = 'S' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE student_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
    } while ($count > 0);
    return $id;
}

function executeQuery($pdo, $student) {
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO students (student_id, first_name, last_name, phone, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $student['studentId'],
            $student['firstName'],
            $student['lastName'],
            $student['phone'],
            $student['email'],
            password_hash($student['password'], PASSWORD_DEFAULT)
        ]);

        $pdo->commit();
        return "Registration successful, Please Login";
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error: " . $e->getMessage();
    }
}


    //references:
    //https://www.php.net/manual/en/pdostatement.fetch.php 
    //https://www.php.net/manual/en/pdo.prepared-statements.php 
    //https://www.php.net/manual/en/control-structures.foreach.php
    //https://getbootstrap.com/docs/4.0/components/forms/
    //https://www.php.net/manual/en/function.password-hash.php
    //https://www.php.net/manual/en/function.password-verify.php

    ?>
