<?php
    function userAllow($assignedRole){
        $conn = db();

        $location = 'dashboard.php';
        $role = (int)$conn->query("SELECT user_role FROM users WHERE user_id = ".$_SESSION["user_id"])->fetch_assoc()["user_role"];
        if($role == $assignedRole){
            return;
            
        }

        $_SESSION['warning_message'] = 'No permission to access this page!';
        header("Location: ./$location");
        exit();
    }



    function userRestrict($assignedRole){
        $conn = db();

        $location = 'dashboard.php';
        $role = (int)$conn->query("SELECT user_role FROM users WHERE user_id = ".$_SESSION["user_id"])->fetch_assoc()["user_role"];
        if($role != $assignedRole){
            return;
        }

        $_SESSION['warning_message'] = 'No permission to access this page!';
        header("Location: ./$location");
        exit();
    }
?>