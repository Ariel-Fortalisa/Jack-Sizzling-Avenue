<?php
    if($_SESSION["user_role"] == 2){
        header("location: dashboard.php");
        exit();
        
    }elseif($_SESSION["user_role"] == 3){
        header("location: dashboard.php");
        exit();
        
    }
?>