<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check if the file is an image
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES["profile_picture"]["tmp_name"]);
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            // Upload profile picture and move to upload folder
            $uploaddir = './upload/user_dp/';
            $uploadfile = $uploaddir . 'user_' . $user_id . '.png';
            move_uploaded_file($_FILES["profile_picture"]['tmp_name'], $uploadfile);

            // Log activity
            $conn->query("
                INSERT INTO `activity_logs`
                        (`activity_logs`, 
                        `date_created`, 
                        `added_by`) 
                    VALUES 
                    ('A new profile picture has been updated.',
                    '$date',
                    '$user_id')
            ");

            $_SESSION['success_message'] = 'Profile picture successfully updated!';
        } else {
            $_SESSION['error_message'] = 'Invalid file type. Please upload an image file (PNG, JPEG, JPG, GIF).';
        }
    } else {
        $_SESSION['error_message'] = 'Error uploading the file. Please try again.';
    }

    header("Location: ./account.php");
    exit;
}
?>