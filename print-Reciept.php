<?php
session_start();
include("./includes/connection.php");
// include('./includes/log_check.php');
date_default_timezone_set('Asia/Manila');

$tr_id = $_GET["transaction"];

$fname = isset($_SESSION["first_name"]) ? $_SESSION["first_name"] : "Unknown";
$lname = isset($_SESSION["last_name"]) ? $_SESSION["last_name"] : "Unknown";  

$sql = "SELECT * FROM system WHERE 1";
$result = $conn->query($sql);

while($sy = $result->fetch_array() ){
    $store_name = $sy["store_name"];
    $store_address = $sy["store_address"];
    $tin = $sy["tin-number"];
    $contact = $sy["contact"];
}

?>

<head>
    <!--Jquery-->
    <script src="./js/jquery.min.js"></script>
    <title>Reciept</title>
    <style>
        * {
            margin: 0;
            padding: 0;

        }

        h3,
        p,
        .product-name,
        .product-quantity,
        .product-subtotal,
        .total-label,
        .total-value,
        .footer {
            font-family: Helvetica, sans-serif;
        }

        hr {
            border: 1px solid black;
            margin: 5px 0px;
        }

        @media print {
            .print-hide {
                display: none !important;
            }
        }


        .store-logo {
            width: 200px;
            height: 90px;
            margin: 0 auto;
            display: block;
            margin-bottom: 10px;

        }

        .address {
            font-size: 12px;
            margin: 5px 0;
            text-align: center;

        }

        .receipt-info p {
            font-size: 13px;
            margin: 3px 0;
        }

        .product-list {
            font-size: 13px;
            margin: 3px 0;
        }

        .product {
            display: flex;
            justify-content: space-between;
            size: 10px;
        }

        .product-name {
            flex: 1;
            word-wrap: break-word;
        }

        .table {
            font-size: 12px;

        }

        .product-quantity {
            flex: 1;
            white-space: nowrap;
            /* Prevent line breaks within the quantity */
            overflow: hidden;
            /* Hide any content that exceeds the container */
            text-overflow: ellipsis;
            /* Display an ellipsis (...) if the content overflows */
            margin-left: 10px;
            margin-right: 10px;
        }

        .product-subtotal {
            flex: 1;
            word-wrap: break-word;
            text-align: right;
        }

        .total {
            font-size: 13px;
            margin: 3px 0;
            float: left;
        }

        .total-label {
            text-align: left;
            float: left;
            clear: left;
            width: 50%;
            font-weight: bold;
        }

        .total-value {
            text-align: right;
            float: left;
            width: 44%;
        }

        .footer {
            font-size: 11px;
            margin-top: 50px;
        }

        .product-name {
            float: left;
        }
    </style>

</head>
<div>
<div class="receipt" style="margin: auto; margin-left: auto; width: 57mm;">
    <img class="store-logo" src="./asset/logo_1.png" alt="logo">
    <h3 style="text-align: center;"><?= $store_name?></h3>
    <p class="address"><?=  $store_address?></p>
    <p class="address">Contact#: <?= $contact?></p>
    <p class="address">VAT REG TIN#: <?= $tin?></p>

    <p class="address">Cashier: <?= $lname.', '.$fname?></p>
    <div class="receipt-info">
        <p style="text-align: center;">Date: <?php echo date('m/d/Y h:i a'); ?></p>
        <p style="text-align: center;">Reference#: <?php echo $tr_id; ?></p>
    </div>
    <hr>
    <div class="product-list">
    <div class="product-list">
    <table class="table">
        <thead>
            <tr>
                <th>NAME</th>
                <th>QTY</th>
                <th>SUBTOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("
                SELECT *
                FROM `transaction_items` 
                WHERE `transaction_id` = '$tr_id'
            ");
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td><p class="product-name">' . $row["product_name"] . '</p></td>
                        <td class="text-right"><p class="product-quantity">x' . $row["qty"] . '</p></td>
                        <td class="text-center"><p class="product-subtotal">' . number_format($row["subtotal"], 2) . '</p></td>
                      </tr>';
            }
            ?>
        </tbody>
    </table>
</div>


    </div>
    <div class="total" style="margin: auto; width: 57mm;">
        <?php
        $total = $conn->query("SELECT `total_amount` FROM `transactions` WHERE `transaction_id` = '$tr_id'")->fetch_assoc()["total_amount"];
        $amountTendered = $conn->query("SELECT `amount_tendered` FROM `transactions` WHERE `transaction_id` = '$tr_id'")->fetch_assoc()["amount_tendered"];
        $vatAmount = $conn->query("SELECT `vat_amount` FROM `transactions` WHERE `transaction_id` = '$tr_id'")->fetch_assoc()["vat_amount"];
        $vatableSales = $conn->query("SELECT `vat_sales` FROM `transactions` WHERE `transaction_id` = '$tr_id'")->fetch_assoc()["vat_sales"];
        $change = $conn->query("SELECT `change_amount` FROM `transactions` WHERE `transaction_id` = '$tr_id'")->fetch_assoc()["change_amount"];
        $discount = $conn->query("SELECT `discount` FROM `transactions` WHERE `transaction_id` = '$tr_id'")->fetch_assoc()["discount"];

        ?>
        <hr>
        <div class="row">
            <div class="col">
                <p class="total-label">Total Amount:</p>
            </div>
            <div class="col">
                <p class="total-value"><?php echo $total ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="total-label">VAT Sale:</p>
            </div>
            <div class="col">
                <p class="total-value"><?php echo $vatableSales ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="total-label">VAT Amount:</p>
            </div>
            <div class="col">
                <p class="total-value"><?php echo $vatAmount ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <p class="total-label">Discount:</p>
            </div>
            <div class="col">
            <p class="total-value"><?php echo $discount ?>%</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <p class="total-label">Cash:</p>
            </div>
            <div class="col">
            <p class="total-value"> <?php echo $amountTendered ?></p><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <p class="total-label">Change:</p>
            </div>
            <div class="col">
            <p class="total-value"> <?php echo $change ?></p>
            </div>
        </div>
    </div>
    <hr>
    <div class="footer" style="margin: auto; width: 57mm;">
        <b>
            <p style="text-align: center;">THIS RECIEPT IS NOT <br> OFFICIAL</p>
    </div>
</div>
</div>
<div id="buttondiv" style="margin: 30px auto; display: flex; justify-content: center;">
    <a href="<?= (isset($_GET["rep"]) and $_GET["rep"] == 1) ? "./sales.php" : "./pos.php" ?>"><button type="button" class="button-back print-hide">Return</button></a>&nbsp;&nbsp;&nbsp;
    <button type="button" class="button-print print-hide" onclick="printReceipt()">Print</button>
</div>
<script>
    function hidebuttons() {
        $('#buttondiv').css("display", "none");
        window.print();
        $('#buttondiv').css("display", "flex");
    }

    function printReceipt() {
        $(".receipt").css("margin-left", "-1px");
        window.print();
        $(".receipt").css("margin-left", "auto");
    }
</script>