<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userRestrict(3);

include ("./includes/log_check.php");
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

    <!-- sweet alert -->
    <script src="./js/sweetalert.min.js"></script>

    <!-- jquery -->
    <script src="./js/jquery.min.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">

    <!-- Bootstrap -->
     


    <title>Inventory</title>
</head>
<style>
   #content main {
      animation: transitionIn-Y-over 1s;
   }
</style>
<body>
<?php 
$pageLocation = "ingredients.php";
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
                    <i class="uil uil-box"></i>
                    Inventory</h2>
                </div>
                <div class="search-box">
                    <button class="btn-search"><i class="uil uil-search"></i></button>
                    <input type="text" id="search" class="input-search" placeholder="Search For...">
                </div>
        </div>

                <div class="inventory-buttons">
                    <div><button class="active" role="button" id="btn1" onclick="location.href='ingredients.php';setActive(this);">Ingredients</button></div>
                    <div><button role="button" id="btn2" onclick="location.href='products.php';setActive(this);">Products</button></div>
                </div>

            <div class="table-data">
                <div class="ingredient-list">
                    <div class="head ingredient-title" style="margin-bottom: 0">
                        <h4>Ingredients List</h4>
                        <div class="add-stock">
                            <button class="add-stock-btn" onclick="modalShow('addStocksModal')">
                                <i class="uil uil-plus"></i>Add Stocks
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; font-size: 12px; gap: .5rem; padding-bottom: 15px; padding-left: 10px">
                
                    </div>

                    <div class="ingredient-table">
                    <table id="ingredientsTable">
                        <thead>
                            <tr>
                                <th style="border-radius: 10px 0 0 0;">#</th>
                                <th>Item</th>
                                <th>Cost</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th style="border-radius: 0 10px 0 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                    </div>
                    <div id="ingredients_pagination">
                        <!--pagination-->
                    </div>
                </div>

        
            </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

   <?= include("./includes/alert_msg.php") ?>
    <script src="./js/script.js"></script>
    <script src="./js/fetchdata-Ingredients.js"></script>
</body>
</html>
