<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userAllow(1);

include ("./includes/log_check.php");
include ("modals.php");

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

    <!-- chart js -->
    <script src="./js/chart.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">


    <title>Point of Sales</title>
</head>
<style>
    #content main {
        animation: transitionIn-Y-over 1s;
    }
</style>

<body>
    <?php
    $pageLocation = "sales.php";
    include("sidebar.php");
    ?>
    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Jack Sizzling Avenue</a>

            <a href="account.php" class="profile">
                <img src="./upload/user_dp/user_<?= $user_id ?>.png">
            </a>
        </nav>
        <!-- NAVBAR -->




        <!-- MAIN -->
        <main style="overflow: auto">
            <div class="head-title">
                <div class="left">
                    <h2>
                        <i class="uil uil-clipboard-notes"></i>
                        Sales Report
                    </h2>
                </div>

    <form action="./print-sales-report.php" method="get">

                    <div class="print">
                        <button type="submit" class="print-btn">
                            <i class="uil uil-print"></i>Print
                        </button>
                    </div>
            </div>

            <div class="reports-buttons">
                <div><button type="button" class="active" role="button" id="btn1" onclick="location.href='sales.php';setActive(this);">Sales</button></div>
                <div><button type="button" role="button" id="btn2" onclick="location.href='inventory-reports.php';setActive(this);">Inventory</button></div>
            </div>
            <ul class="box-info">
                <li>
                    <img src="img/sales.png" class="icon">
                    <span class="text">
                        <h3 id="total_Sales">₱0</h3>
                        <p>Overall Sales</p>
                    </span>
                </li>
                <li>
                    <img src="img/transaction.png" class="icon">
                    <span class="text">
                        <h3 id="total_transaction">0</h3>
                        <p>Total Transaction</p>
                    </span>
                </li>
                <li>
                    <img src="img/inventory_cost.png" class="icon">
                    <span class="text">
                        <h3 id="total_cost">₱0</h3>
                        <p>Total Inventory Cost</p>
                    </span>
                </li>
                <li>
                    <img src="img/top-selling.png" class="icon">
                    <span class="text">
                        <h3 id="top_Selling">₱0</h3>
                        <p>Top Selling Sales</p>
                    </span>
                </li>
            </ul>

            <div class="sales_container">
                <div class="sales_chart">
                    <div class="head-sales-chart">
                        <h4 id="header-sales-chart">Daily Sales (September 2024)</h4>
                        <div class="sales-filter">
                            <select name="basis" id="basis" onchange="generateChart('change')">
                                <option value="Daily" selected>Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                            </select>

                            <select id="month" name="month" onchange="generateChart('change')" style="width: 60%;">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>

                            <select id="year" name="year" onchange="generateChart('change')">
                                <?php
                                $minYear = $conn->query("SELECT YEAR(MIN(date_created)) AS min_year FROM transactions")->fetch_assoc()["min_year"];
                                for ($x = $minYear; $x <= date("Y"); $x++) {
                                    echo
                                    '<option value="' . $x . '">' . $x . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="body-sales-chart">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <div class="top_selling">
                    <div class="head-top-selling">
                        <h4>Top Selling Product</h4>
                        <div class="selling-filter">
                            <select style="width: 10rem; border-radius: 6px;" name="sort" id="sort" onchange="generateChartPrd()">
                                <option value="top">Top Selling</option>
                                <option value="least">Least Selling</option>
                            </select>
                        </div>
                    </div>

                    <div class="body-top-selling">
                        <canvas id="sellingChart"></canvas>
                    </div>
                </div>
            </div>
            </form>

            <div class="table-data">
                <div class="purchase-order">
                    <div class="head order-list" style="margin-bottom: 0">
                        <h4>Purchase Order List</h4>
                        <div class="search-box">
                            <button class="btn-search"><i class="uil uil-search"></i></button>
                            <input id="search" name="search" type="text" class="input-search" placeholder="Search For...">
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; font-size: 12px; gap: .5rem; padding-bottom: 15px; padding-left: 10px">
                    </div>

                    <div class="sales-table">
                        <table class="table" id="sales-table">
                            <thead>
                                <tr>
                                    <th style="border-radius: 10px 0 0 0;">#</th>
                                    <th>Reference#</th>
                                    <th>(₱)Total Amount</th>
                                    <th>(₱)Amount Tendered</th>
                                    <th>(₱)Vat Amount</th>
                                    <th>(₱)Vat Sales</th>
                                    <th>(₱)Change</th>
                                    <th>(%)Discount</th>
                                    <th>Date</th>
                                    <th style="border-radius: 0 10px 0 0;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--display sales-->
                            </tbody>
                        </table>

                    </div>
                    <div id="sales_pagination">
                        <!-- <ul class="pagination--link">

                            <li> <a href="#" class="prev"> <i class="uil uil-angle-left-b" aria-hidden="true"></i></a></li>
                            <li> <a href="#"> 1 </a></li>
                            <li> <a href="#" class="active"> 2 </a></li>
                            <li> <a href="#"> 3 </a></li>
                            <li> <a href="#"> 4 </a></li>
                            <li> <a href="#"> 5 </a></li>
                            <li> <a href="#"> 6 </a></li>
                            <li> <a href="#" class="dots"> <i class="uil uil-ellipsis-h"></i> </a></li>
                            <li> <a href="#"> 10 </a></li>
                            <li> <a href="#" class="next"><i class="uil uil-angle-right-b" aria-hidden="true"></i></a></li> 

                        </ul> -->
                    </div>
                </div>

    </form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="./js/script.js"></script>
    <script src="./js/fetchdata-sales.js"></script>
</body>

</html>