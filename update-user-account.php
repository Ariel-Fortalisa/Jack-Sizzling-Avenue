<?php
session_start();
require("./includes/connection.php");

$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$user_role = $_SESSION["user_role"];
$user_id = $_SESSION["user_id"];
$password = $_SESSION["password"];
$user_name = $_SESSION["username"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $new_password = ($_POST["new_password"] == '') ? $password : $_POST["new_password"];
    $old_password = $_POST["old_password"];
    $security_question = $_POST["security_question"];
    $answer = $_POST["answer"];

    // Fetch the current user's password from the database
    $userSQL = $conn->query("SELECT password FROM users WHERE user_id = '$user_id'");
    $user = $userSQL->fetch_assoc();

    if (password_verify($old_password, $user['password'])) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $conn->query("
            UPDATE `users` 
            SET 
                `first_name`= '$first_name',
                `last_name`= '$last_name',
                `username`='$username',
                `password`='$hashed_password',
                `security_question1`='$security_question',
                `answer_1`='$answer' 
            WHERE user_id = '$user_id'
        ");

        $conn->query("
            INSERT INTO `activity_logs`
                (`activity_logs`, 
                `date_created`, 
                `added_by`) 
            VALUES 
                ('Updated the details of $user_name account.',
                '$date',
                '$user_id')
        ");

        $_SESSION["first_name"] = $first_name;
        $_SESSION["last_name"] = $last_name;
        $_SESSION["username"] = $username;  
        $_SESSION["password"] = $hashed_password;

        $_SESSION['success_message'] = 'Account details successfully updated!';
    } else {
        $conn->query("
            INSERT INTO `activity_logs`
                (`activity_logs`, 
                `date_created`, 
                `added_by`) 
            VALUES 
                ('Failed to update the details of the $user_name account.',
                '$date',
                '$user_id')
        ");

        $_SESSION['error_message'] = 'Password does not match please try again!';
    }


    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    header("location: ./account.php");
    exit();
}
?>