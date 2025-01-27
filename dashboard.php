<?php
session_start();
include('./includes/connection.php');
include('./includes/log_check.php');
include("modals.php");
date_default_timezone_set('Asia/Manila');

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

    <!-- Jquery -->
    <script src="./js/jquery.min.js"></script>

    <!-- chart js -->
    <script src="./js/chart.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="./asset/logo_1.png" type="image/png" />

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">



    <title>Dashboard</title>
</head>
<style>
    #content main {
        animation: transitionIn-Y-over 1s;
    }
</style>

<body>
    <?php
    $pageLocation = "dashboard.php";
    include("sidebar.php");
    ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Jack Sizzling Avenue</a>

            <a href="./account.php" class="profile">
                <img src="./upload/user_dp/user_<?= $user_id ?>.png">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main style="padding: 24px 15px;">
            <div class="head-title">
                <div class="left">
                    <h2>
                        <i class="uil uil-apps"></i>
                        Dashboard
                    </h2>
                </div>
            </div>

            <div class="dashboard-content">
                <div class="first-div">
                    <ul class="box-info">
                        <li>
                            <img src="img/cash_bag.png" class="icon">
                            <span class="text">
                                <h3 id="month_sale">0</h3>
                                <p>Sales This Month</p>
                            </span>
                        </li>
                        <li>
                            <img src="img/cash.png" class="icon">
                            <span class="text">
                                <h3 id="sales_today">0</h3>
                                <p>Sales Today</p>
                            </span>
                        </li>
                        <li>
                            <img src="img/transaction.png" class="icon">
                            <span class="text">
                                <h3 id="today_transaction">1</h3>
                                <p>Today Transaction</p>
                            </span>
                        </li>
                    </ul>


                    <div class="table-data">
                        <div class="Order_List_Graph">
                            <div class="head">
                                <h2>Sales Graph</h2>
                            </div>
                            <select hidden="hidden" name="last7days" id="last7days">
                                <option value="current"></option>
                            </select>
                            <div style="width: 60%; margin-left: auto; margin-right: auto;">
                                <canvas id="graph"></canvas>
                            </div>
                        </div>

                    </div>
                    <div class="table-data">
                        <div class="order" style="height: 370px;">
                            <div class="head">
                                <h2>Recent Transaction</h2>
                            </div>
                            <div style="height: 80%; overflow-y: auto;">
                                <table class="table" id="recent_transaction">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; border-radius: 10px 0 0 0;">#</th>
                                            <th style="text-align: center;">Reference#</th>
                                            <th style="text-align: center;">Date Order</th>
                                            <th style="text-align: center;">Total Amount</th>
                                            <th style="text-align: center; border-radius: 0 10px 0 0;">Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Transaction rows will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="second-div" style="height: 555px;">
                    <div class="second-div-content" style="height: 530px;">
                        <div class="expired-status">
                            <div class="head">
                                <h4 id="stock_header">Low Stock Items</h4>
                                <div class="expiration-filter">
                                    <select id="stockFilter" style="width: 7rem; border-radius: 6px;">
                                        <option value="2" selected class="selected">Low Stock</option>
                                        <option value="3">Out of Stock</option>
                                    </select>
                                </div>
                            </div>

                            <div class="ingredients-table">
                                <div class="stock-status low-stock" id="lowStockSection" style="display: block;">
                                    <table class="table" id="low_stock_tbl">
                                        <thead>
                                            <tr>
                                                <th style="border-radius: 10px 0 0 0;">#</th>
                                                <th>Item</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div id="stocks_ingredients_lowstock_status_pagination">
                                        <!-- in stock -->
                                    </div>
                                </div>

                                <div class="stock-status out-of-stock" id="outOfStockSection" style="display: none;">
                                    <table class="table" id="out_of_stock_tbl">
                                        <thead>
                                            <tr>
                                                <th style="border-radius: 10px 0 0 0;">#</th>
                                                <th>Item</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Chicharon Bulaklak</td>
                                                <td>
                                                    <div style="width: 5rem; margin: auto; background-color: #c21807; color: #fff; padding: .3rem .2rem; border-radius: .3rem">
                                                        Out of stock</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="stocks_ingredients_out_of_stock_status_pagination">
                                        <!-- in stock -->
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="stock-status">
                            <div class="head">
                                <h4 id="status_items">Nearly Expire Items</h4>
                                <div class="stock-filter">
                                    <select id="expiryFilter" style="width: 7rem; border-radius: 6px;">
                                        <option value="2" selected class="selected">Nearly Expire</option>
                                        <option value="3">Expired</option>
                                    </select>
                                </div>
                            </div>

                            <div class="ingredients-table">
                                <!-- Nearly expire  TABLE-->
                                <div class="expiration-status nearlyExpire" id="nearlyExpire" style="display: block;">
                                    <table class="table" id="nearly_expiration_tbl">
                                        <thead>
                                            <tr>
                                                <th style="border-radius: 10px 0 0 0;">Batch ID</th>
                                                <th>Item</th>
                                                <th style="width: 150px;">Expiration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- nearly expiration field -->
                                        </tbody>
                                    </table>
                                    <div id="nearly_pagination">
                                        <!-- nearly pagination -->
                                    </div>
                                </div>
                                <!-- Nearly expire  TABLE-->

                                <!-- expire  TABLE-->
                                <div class="expiration-status Expired" id="Expired" style="display: none;">
                                    <table class="table" id="expired_tbl">
                                        <thead>
                                            <tr>
                                                <th style="border-radius: 10px 0 0 0;">Batch ID</th>
                                                <th>Item</th>
                                                <th style="width: 150px;">Expiration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- expired field -->
                                        </tbody>
                                    </table>
                                    <div id="Expired_pagination">
                                        <!-- expiry -->
                                    </div>
                                </div>
                                <!-- expire  TABLE-->
                            </div>
                        </div>
                    </div>
                </div>


        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <?= include('./includes/alert_msg.php') ?>
    <script src="./js/script.js"></script>
    <script src="./js/fetchdata-dashboard.js"></script>
    <script>
        $(document).ready(function() {
            $('#stockFilter').on('change', function() {
                let selectedValue = $(this).val();

                $("#lowStockSection").hide();
                $("#outOfStockSection").hide();

                if (selectedValue === "2") {
                    $("#lowStockSection").show();
                    $('#stock_header').html("Low Stock Items");
                } else if (selectedValue === "3") {
                    $("#outOfStockSection").show();
                    $('#stock_header').html("Out of Stock Items");
                }


            });

            $('#expiryFilter').on('change', function() {
                let expiryValue = $(this).val();

                $('#nearlyExpire').hide();
                $('#Expired').hide();

                if (expiryValue === "2") {
                    $('#nearlyExpire').show();
                    $('#status_items').html("Nearly Expire Items");
                } else if (expiryValue === "3") {
                    $('#Expired').show();
                    $('#status_items').html("Expired Items");
                }

            });

        });
    </script>
</body>

</html>