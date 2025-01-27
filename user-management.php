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
     


    <title>User Management</title>
</head>
<style>
   #content main {
      animation: transitionIn-Y-over 1s;
   }
</style>
<body>
<?php 
$pageLocation = "user-management.php";
include ("sidebar.php"); 
?>
<!-- CONTENT -->
<section id="content">
		<!-- NAVBAR -->
		<nav>
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Jack Sizzling Avenue</a>

            <a href="#" class="profile">
            <img src="./upload/user_dp/user_<?=$user_id?>.png">
            </a>
        </nav>
		<!-- NAVBAR -->




    <!-- MAIN -->
    <main style="overflow: auto">
        <div class="head-title">
                <div class="left">
                    <h2>
                    <i class="uil uil-users-alt"></i>
                    Manage Users </h2>
                </div>
                        
                <div class="search-box">
                        <button class="btn-search"><i class="uil uil-search"></i></button>
                        <input type="text" id="search" name="search" class="input-search" placeholder="Search For...">
                    </div>
            </div>

            <div class="table-data">
                <div class="users-list">
                    <div class="head users-title" style="margin-bottom: 0">
                        <h4>Users List</h4>
                        <div class="add-users">
                            <button class="add-users-btn" onclick="modalShow('addUserModal')">
                                <i class="uil uil-plus"></i>Add User
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; font-size: 12px; gap: .5rem; padding-bottom: 15px; padding-left: 10px">
                        
                    </div>

                    <div class="users-table">
                    <table class="table" id="user_table">
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
                         <!--display user-->
                        </tbody>
                    </table>
                    </div>
                    <div id="user_pagination">
               
                    </div>
                </div>

        
            </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->
<?= include("./includes/alert_msg.php") ?>
<script src="./js/script.js"></script>
<script src="./js/fetchdata-accounts.js"></script>
<script>
const selectProfile = document.querySelector('#select-profile');
const inputProfile = document.querySelector('#profile');
const profileArea = document.querySelector('#profile-area');

selectProfile.addEventListener('click', function () {
	inputProfile.click();
})

inputProfile.addEventListener('change', function () {
	const image = this.files[0]
	if(image.size < 2000000) {
		const reader = new FileReader();
		reader.onload = ()=> {
			const allImg = profileArea.querySelectorAll('img');
            const allText = profileArea.querySelectorAll('#profile-text');
			allImg.forEach(item=> item.remove());
            allText.forEach(item=> item.remove());
			const imgUrl = reader.result;
			const img = document.createElement('img');
			img.src = imgUrl;
			profileArea.appendChild(img);
			profileArea.classList.add('active');
			profileArea.dataset.img = image.name;
		}
		reader.readAsDataURL(image);
	} else {
		alert("Image size more than 2MB");
	}
})


</script>
</body>
</html>
