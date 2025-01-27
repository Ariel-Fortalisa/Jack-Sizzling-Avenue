<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = $_POST["first_name"];
    $last = $_POST["last_name"];
    $username = $_POST["username"];
    $user_role = $_POST["user_role"];
    $pass = $_POST["password"];
    $sc_question = $_POST["sc_question"];
    $answer = $_POST["answer"];

    $password = password_hash($pass, PASSWORD_DEFAULT);

    $SQL = "INSERT INTO `users`
                        (`first_name`,
                        `last_name`, 
                        `username`,
                        `password`,
                        `user_role`, 
                        `archive_status`, 
                        `security_question1`, 
                        `answer_1`) 
                VALUES ('$first',
                        '$last',
                        '$username',
                        '$password',
                        '$user_role',
                        '0',
                        '$sc_question',
                        '$answer')";
    
    $result = $conn->query($SQL);

}


$userId = $conn->query("SELECT MAX(user_id) AS id FROM users")->fetch_assoc()["id"];

  // Upload user profile picture image and move to upload folder
  if (isset($_FILES["user_pic"])) {
    $uploaddir = './upload/user_dp/';
    $uploadfile = $uploaddir . 'user_' . $userId . '.png';
    move_uploaded_file($_FILES["user_pic"]['tmp_name'], $uploadfile);
}

$conn->query("
INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Added a new account with the username $username.',
    '$date',
    '$user_id')

");

include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");

$_SESSION['success_message'] = 'New user account successfully Added!'; 
header("Location: user-management.php");
exit();


?>