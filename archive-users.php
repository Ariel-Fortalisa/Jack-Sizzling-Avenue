<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userAllow(1);

include("./includes/log_check.php");
include ("modals.php"); 

$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$user_role = $_SESSION["user_role"];
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$password = $_SESSION["password"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="./js/sweetalert.min.js"></script>

    <script src="./js/jquery.min.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">

    <!-- Bootstrap -->
     


    <title>Archive Users</title>
</head>
<style>
   #content main {
      animation: transitionIn-Y-over 1s;
   }
</style>
<body>
<?php 
$pageLocation = "archive-users.php";
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
                <div><button role="button" onclick="location.href='activity-logs.php';setActive(this);">Activity Logs</button></div>
                <div><button class="active" role="button" onclick="location.href='archive-users.php';setActive(this);">Archive</button></div>
            </div>

            <div class="table-data">
                <div class="archive-users-list">
                <div class="head archive-users-title" style="margin-bottom: 0">
                        <h4>Archive Users</h4>
                        <div class="archive-buttons">
                            <div><button role="button" onclick="location.href='archive-ingredients.php';setActive(this);">Ingredients</button></div>
                            <div><button role="button" onclick="location.href='archive-batch.php';setActive(this);">Batch</button></div>
                            <div><button role="button" onclick="location.href='archive-products.php';setActive(this);">Products</button></div>
                            <div><button class="active" role="button" onclick="location.href='archive-users.php';setActive(this);">Users</button></div>
                            <div><button role="button" onclick="location.href='archive-category.php';setActive(this);">Category</button></div>
                            <div><button role="button" onclick="location.href='archive-measurement.php';setActive(this);">Measurement</button></div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; font-size: 12px; gap: .5rem; padding-bottom: 15px; padding-left: 10px">
                    
                    </div>

                    <div class="archive-users-table">
                    <table class="table" id="archiveaccount_table">
                        <thead>
                            <tr>
                                <th style="border-radius: 10px 0 0 0;">#</th>
                                <th>Profile</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th style="border-radius: 0 10px 0 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- input field -->
                        </tbody>
                    </table>
                    </div>
                    <div id="Archiveuser_pagination">
                        
                    </div>
                </div>

        
            </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<?= include ("./includes/alert_msg.php") ?>
<script src="./js/script.js"></script>
<script src="./js/fetchdata-archiveAccounts.js"></script>
</body>
</html>
