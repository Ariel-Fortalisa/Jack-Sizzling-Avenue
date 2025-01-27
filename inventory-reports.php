<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userRestrict(3);

include ("./includes/log_check.php");
include ("modals.php"); 

$role = (int)$conn->query("SELECT user_role FROM users WHERE user_id = ".$_SESSION["user_id"])->fetch_assoc()["user_role"];

$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$user_role = $_SESSION["user_role"];
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Jquery -->
    <script src="./js/jquery.min.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <title>Inventory Reports</title>
</head>
<style>
    #content main {
        animation: transitionIn-Y-over 1s;
    }
</style>

<body>
    <?php
    $pageLocation = "inventory-reports.php";
    include("sidebar.php");
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
        <main>
            <div class="head-title">
                <div class="left">
                    <h2>
                        <i class="uil uil-clipboard-notes"></i>
                        Inventory Reports
                    </h2>
                </div>

                <form action="./print-inventory-report.php" method="get">

                <div class="print">
                    <button type="submit" class="print-btn">
                        <i class="uil uil-print"></i>Print
                    </button>
                </div>
            </div>

            <div class="reports-buttons">
            <?php   if($role == 1){   ?>
                <div><button type="button" role="button" id="btn1" onclick="location.href='sales.php';setActive(this);">Sales</button></div>
                <div><button type="button" class="active" role="button" id="btn2" onclick="location.href='inventory-reports.php';setActive(this);">Inventory</button></div>
                <?php   }   ?>
                <?php   if($role == 2){   ?>
                <div><button type="button" class="active" role="button" id="btn2" onclick="location.href='inventory-reports.php';setActive(this);">Inventory</button></div>
                <?php   }   ?>

            </div>

            <ul class="box-info" style="margin-top: 20px;">
                <li>
                    <img src="img/sales.png" class="icon">
                    <span class="text">
                        <h3 id="inventory_cost">₱0</h3>
                        <p>Total Inventory Cost</p>
                    </span>
                </li>
                <li>
                    <img src="img/inventory_cost.png" class="icon">
                    <span class="text">
                        <h3 id="overall_count_items">0</h3>
                        <p>Total Inventory Item</p>
                    </span>
                </li>
                <li>
                    <img src="img/low-stock.png" class="icon">
                    <span class="text">
                        <h3 id="low_stock_batches">0</h3>
                        <p>Low Stock Batches</p>
                    </span>
                </li>
                <li>
                    <img src="img/expired.png" class="icon">
                    <span class="text">
                        <h3 id="expired_items_count">0</h3>
                        <p>Expired Batches</p>
                    </span>
                </li>
            </ul>

            <div class="ingredients_container">
                <div class="ingredients_status">
                    <div class="head-ingredients-status">
                        <div class="ingredients-filter">
                            <select name="stockFilter" id="stockFilter">
                                <option value="0" selected class="selected">All</option>
                                <option value="1">In Stock</option>
                                <option value="2">Low Stock</option>
                                <option value="3">Out of Stock</option>
                            </select>
                        </div>
                    </div>

                    <div class="body-ingredients-status">
                        <div class="stock-status in-stock" id="inStock" style="display: block;">
                            <h4>In Stock Ingredients Status</h4>
                            <div class="ingredient-table in-stock">
                                <table class="table" id="table_stockin">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 10px 0 0 0;">#</th>
                                            <th>Item</th>
                                            <th>(₱)Cost</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- field for stock in -->
                                    </tbody>
                                </table>
                                <div id="stocks_ingredients_Instock_status_pagination">
                                    <!-- in stock -->
                                </div>
                            </div>
                        </div>

                        <div class="stock-status low-stock" id="lowStockSection" style="display: block;">
                            <h4>Low Stock Ingredients Status</h4>
                            <div class="ingredient-table low-stock">
                                <table class="table" id="lowStock">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 10px 0 0 0;">#</th>
                                            <th>Item</th>
                                            <th>(₱)Cost</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- field for low stock -->
                                    </tbody>
                                </table>
                                <div id="lowStock_pagination">
                                    <!-- in stock -->
                                </div>
                            </div>
                        </div>

                        <div class="stock-status out-of-stock" id="outOfStockSection" style="display: block;">
                            <h4>Out of Stock Ingredients Status</h4>
                            <div class="ingredient-table out-of-stock">
                                <table class="table" id="out_of_stocks">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 10px 0 0 0;">#</th>
                                            <th>Item</th>
                                            <th>(₱)Cost</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <!-- field of out of stocks -->
                                    </tbody>
                                </table>
                                <div id="OutofStocks_pagination">
                                <!-- field of pagination -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="expiration-status-container">
                    <div class="head-expiration-status">
                        <div class="expiration-filter">
                            <select name="expiryFilter" id="expiryFilter" style="width: 10rem; border-radius: 6px;">
                                <option value="0" selected class="selected">All</option>
                                <option value="1">Good</option>
                                <option value="2">Expiring</option>
                                <option value="3">Expired</option>
                            </select>
                        </div>
                    </div>

                    <div class="body-expiration-status">
                        <div class="expiration-status good" id="goodBatch">
                            <h4>Good Ingredients</h4>
                            <div class="products-table good">
                                <table class="table" id="good_status_table">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 10px 0 0 0;">#</th>
                                            <th style="width: 30%;">Item</th>
                                            <th>(₱)cost</th>
                                            <th>Batch ID</th>
                                            <th>Expiration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            
                                    </tbody>
                                </table>
                                <div id="goodstatus_pagination">
                                    <!-- goodstatus pagination -->
                                </div>
                            </div>
                        </div>

                        <div class="expiration-status expiring" id="NearlyExpireBatch">
                            <h4>Expiring Ingredients</h4>
                            <div class="products-table expiring">
                                <table class="table" id="nearly_expire_table">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 10px 0 0 0;">#</th>
                                            <th style="width: 30%;">Item</th>
                                            <th>(₱)cost</th>
                                            <th>Batch ID</th>
                                            <th>Expiration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- field of nearly expire -->
                                    </tbody>
                                </table>
                                <div id="nearly_expire_pagination">
                                    <!-- pagination for expire -->
                                </div>
                            </div>
                        </div>

                        <div class="expiration-status expired" id="ExpiredBatch">
                            <h4>Expired Ingredients</h4>
                            <div class="products-table expired">
                                <table class="table" id="expire_table">
                                    <thead>
                                        <tr>
                                            <th style="border-radius: 10px 0 0 0;">#</th>
                                            <th style="width: 30%;">Item</th>
                                            <th>(₱)cost</th>
                                            <th>Batch ID</th>
                                            <th>Expiration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  <!-- expired -->
                                </table>
                                <div id="expired_pagination">
                                    <!-- expiration for pagination -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="./js/script.js"></script>
    <script src="./js/fetchdata-inventory-reports.js"></script>
    <script>
 $(document).ready(function () {
    $('#stockFilter').on('change', function () {
        let selectedValue = $(this).val();

        $("#inStock").hide();
        $("#lowStockSection").hide();
        $("#outOfStockSection").hide();

        if (selectedValue === "1") {
            $("#inStock").show();
        } else if (selectedValue === "2") {
            $("#lowStockSection").show();
        } else if (selectedValue === "3") {
            $("#outOfStockSection").show();
        } else {
            // Default: show all
            $("#inStock").show();
            $("#lowStockSection").show();
            $("#outOfStockSection").show();
        }
    });

    $('#expiryFilter').on('change', function(){
        let expiryValue = $(this).val();

        $("#goodBatch").hide();
        $("#NearlyExpireBatch").hide();
        $("#ExpiredBatch").hide();

        if(expiryValue === "1"){
            $("#goodBatch").show();
        } else if(expiryValue === "2"){
            $("#NearlyExpireBatch").show();
        } else if(expiryValue === "3"){
            $("#ExpiredBatch").show();
        } else {
        $("#goodBatch").show();
        $("#NearlyExpireBatch").show();
        $("#ExpiredBatch").show();
        }

    })
});

    </script>

</body>

</html>