<?php
session_start();
include ("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $system_id = $conn->query("SELECT MAX(system_id) AS id FROM system")->fetch_assoc()["id"];

    // Upload product image and move to upload folder
    if (isset($_FILES["bglogin"])) {
        $uploaddir = './asset/';
        $uploadfile = $uploaddir . 'loginBG_' . $system_id . '.png';
        move_uploaded_file($_FILES["bglogin"]['tmp_name'], $uploadfile);
    }
      // Log activity
      $conn->query("
      INSERT INTO `activity_logs`
              (`activity_logs`, 
              `date_created`, 
              `added_by`) 
          VALUES 
          ('Login background image updated successfully.',
          '$date',
          '$user_id')
  ");
}
$_SESSION['success_message'] = 'Login background successfully updated!';
header("Location: ./system-settings.php");
exit;
?>