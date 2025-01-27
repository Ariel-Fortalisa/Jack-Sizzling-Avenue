<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userAllow(1);

include("./includes/log_check.php");
include ("modals.php"); 

$user_id = $_SESSION["user_id"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="./js/jquery.min.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">

    <!-- Bootstrap -->
     


    <title>Activity Logs</title>
</head>
<style>
   #content main {
      animation: transitionIn-Y-over 1s;
   }
</style>
<body>
<?php 
$pageLocation = "activity-logs.php";
include ("sidebar.php"); 
?>
<!-- CONTENT -->
<section id="content">
		<!-- NAVBAR -->
		<nav>
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Jack Sizzling Avenue</a>

            <a href="account.php" class="profile">
            <img src="./upload/user_dp/user_<?=$user_id?>.png">
            </a>
        </nav>
		<!-- NAVBAR -->




    <!-- MAIN -->
    <main style="overflow: auto; padding: 10px 24px;">
        <div class="head-title">
                <div class="left">
                    <h2>
                    <i class="uil uil-setting"></i>
                    Settings</h2>
                </div>
                        
                <div class="search-box">
                        <button class="btn-search"><i class="uil uil-search"></i></button>
                        <input type="text" class="input-search" placeholder="Search For...">
                    </div>
            </div>

            <div class="settings-buttons">
                <div><button role="button" onclick="location.href='system-settings.php';setActive(this);">System Settings</button></div>
                <div><button role="button" onclick="location.href='category.php';setActive(this);">Category</button></div>
                <div><button role="button" onclick="location.href='measurement.php';setActive(this);">Measurement</button></div>
                <div><button class="active" role="button" onclick="location.href='activity-logs.php';setActive(this);">Activity Logs</button></div>
                <div><button role="button" onclick="location.href='archive-ingredients.php';setActive(this);">Archive</button></div>
            </div>

            <div class="table-data">
                <div class="activity-logs">
                    <div class="head activity-logs-title" style="margin-bottom: 0">
                        <h4>Activity Logs</h4>
                    </div>

                    <div style="display: flex; align-items: center; font-size: 12px; gap: .5rem; padding-bottom: 15px; padding-left: 2.5rem">
                       
                    </div>

                    <div class="activity-logs-body">
                        <div class="logs-content">
                            <ul id="list_activity">
                          <!-- content -->
                            </ul>
                        </div>
                    
                    </div>
                    <div id="activity_pagination" style="padding-right: 4rem">

                    </div>
                </div>

        
            </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="./js/script.js"></script>
<script src="./js/fetchdata-activity_logs.js"></script>
</body>
</html>
