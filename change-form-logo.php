<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $system_id = $conn->query("SELECT MAX(system_id) AS id FROM system")->fetch_assoc()["id"];

    // Check if the file is an image
    if (isset($_FILES["store_logo"]) && $_FILES["store_logo"]["error"] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES["store_logo"]["tmp_name"]);
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            // Upload product image and move to upload folder
            $uploaddir = './asset/';
            $uploadfile = $uploaddir . 'logo_' . $system_id . '.png';
            move_uploaded_file($_FILES["store_logo"]['tmp_name'], $uploadfile);

            // Log activity
            $conn->query("
                INSERT INTO `activity_logs`
                        (`activity_logs`, 
                        `date_created`, 
                        `added_by`) 
                    VALUES 
                    ('A new store logo has been updated.',
                    '$date',
                    '$user_id')
            ");

            $_SESSION['success_message'] = 'Store logo successfully updated!';
        } else {
            $_SESSION['error_message'] = 'Invalid file type. Please upload an image file (PNG, JPEG, JPG, GIF).';
        }
    } else {
        $_SESSION['error_message'] = 'Error uploading the file. Please try again.';
    }

    header("Location: ./system-settings.php");
    exit;
}
?>
