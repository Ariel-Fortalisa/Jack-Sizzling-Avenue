<?php
session_start();
date_default_timezone_set('Asia/Manila');
include('./includes/connection.php');

include('./includes/userValidate.php');
userRestrict(2);

include('./includes/log_check.php');
include('./modals.php');

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

    <script src="./js/jquery.min.js"></script>

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

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    /* input[type=number] {
        -moz-appearance: textfield;
    } */
</style>

<body>
    <?php
    $pageLocation = "pos.php";
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
        <main style="padding: 10px 24px;">
            <div class="head-title">
                <div class="left">
                    <h2>
                        <i class="uil uil-shopping-cart"></i>
                        Point of Sales
                    </h2>
                </div>

                <div class="search-box">
                    <button class="btn-search"><i class="uil uil-search"></i></button>
                    <input type="text" id="search" name="search" class="input-search" placeholder="Search For...">
                </div>
            </div>

            <div class="category-buttons">
                <div><button class="active category-btn" role="button" onclick="displayProduct()">All</button></div>
                <?php
                $category = $conn->query("
                SELECT * FROM `categories` WHERE archive_status = 0;
                ");
                while ($row = $category->fetch_assoc()) {
                    $categoryId = $row["id"];
                    echo "
                        <div>
                            <button class='category-btn' role='button' onclick='displayProduct({category: $categoryId})'>$row[category_name]</button>
                        </div>
                    ";
                }

                ?>
            </div>

            <div class="products_container">
                <div class="products" id="product_display">

                </div>

                <div class="cart_container">
                    <div class="cart_header">
                        <h4>Order List </h4>
                    </div>

                    <div class="empty_cart" id="noResults" style="display: none;">
                        <img src="img/shopping.png">
                        <h4>Your Order is <span>Empty!</span></h4>
                    </div>

                    <div class="discount" id="discountSection">
                        <div class="select-menu" id="discount" style="padding-top: 0; width: 70%">
                            <p class="discount title">Discount: <i class="uil uil-pricetag-alt"></i></p>
                            <button type="button" class="discount-btn" onclick="modalShow('discountModal')">Select Discount</button>
                        </div>
                    </div>

                    <!-- <form action="./pos-transaction-form.php" method="post"> -->
                    <form id="pos-form" action="./pos-transaction-form.php" method="POST">
                        <div class="cart-table" id="cartTable">
                            <div class="cart-item">
                                <table id="table_append">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th>QTY</th>
                                            <th>SUBTOTAL</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="cart_footer" class="cart_footer">
                            <div class="payment">
                                <div class="input_payment">
                                    <i class="uil uil-money-bill-stack"></i>
                                    <div class="amount_tendered">
                                        <input type="number" class="pay" id="inputAmounttendered" name="inputAmounttendered" step="0.01" required>
                                        <span>Amount Tendered</span>
                                    </div>
                                </div>

                                <div class="total_amount">
                                    <h5 class="amount">Total Amount: </br><span id="total_amount"> ₱ 0.00</span></h5>
                                </div>
                            </div>

                            <div id="hidden_inputs" class="change">
                                <!--input field-->
                                <input type="hidden" id="inputDiscount" name="inputDiscountVal">
                                <input type="hidden" id="inputTotal_Amount" name="inputTotal_Amount">
                                <input type="hidden" id="inputChange" name="inputChange">
                                <input type="hidden" id="inputVat_sales" name="inputvat_sales">
                                <input type="hidden" id="inputVat_amount" name="inputVat_amount">
                                <!-- input field for discounts -->
                                <input type="hidden" id="hidden_fullname" name="fullname">
                                <input type="hidden" id="hidden_id_number" name="id_number">
                                <input type="hidden" id="hidden_discount_value" name="discount_value">
                                <input type="hidden" id="hidden_discount_text" name="discount_text">

                                <span class="total_change">Change: </br><span id="change"> ₱0.00</span></span>
                                <span class="total_change">Vatable Sales: </br><span id="vat_sales"> ₱0.00</span></span>
                                <span class="total_change">Vat Amount: </br><span id="vat_amount"> ₱0.00</span>
                            </div>

                            <div class="submit_button">
                                <button type="submit" class="submit" id="check_out">
                                    <p class="submit_title">Check Out</p>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="./js/script.js"></script>
    <script src="./js/fetchdata-posProducts.js"></script>
    
</body>

</html>