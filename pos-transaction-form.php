<?php
session_start();

include('./includes/connection.php');

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");
$user =  $_SESSION["user_id"];
$fname = $_SESSION["first_name"];
$lname = $_SESSION["last_name"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total_amount = $_POST["inputTotal_Amount"];
    $change = $_POST["inputChange"];
    $vat_sales = $_POST["inputvat_sales"];
    $vat_amount = $_POST["inputVat_amount"];
    $amount_tendered = $_POST["inputAmounttendered"];
    //details of items
    $productIds = $_POST["product_ids"];
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantities"];
    print_r($quantity);
    $size_id = $_POST["size_ids"];
    $size_name = $_POST["size_name"];
    $sub_total = $_POST["subtotal"];
    //addons
    $addonsId = $_POST["addons_id"] ?? [];
    $addonsName = $_POST["addons_name"] ?? [];
    $addons_price = $_POST["addons_price"] ?? [];
    //customer details
    $cs_fullname = $_POST["fullname"];
    $id_number = $_POST["id_number"];
    $discount_value = $_POST["discount_value"];
    $discount_text = $_POST["discount_text"];

    // Split the string by the space character
    $parts = explode(' ', $discount_text);

    // Get the second part, which should be the "Student"
    $discount_type = isset($parts[1]) ? $parts[1] : '';



    //Insert Transaction
    $transaction = $conn->query("
        INSERT INTO `transactions`
            (`total_amount`, 
            `amount_tendered`,
            `vat_amount`, 
            `vat_sales`, 
            `change_amount`, 
            `discount`,
            `cs_name`,
            `cs_id`,
            `discount_type`,
            `date_created`, 
            `added_by`) 
        VALUES 
            ('$total_amount',
            '$amount_tendered',
            '$vat_amount',
            '$vat_sales',
            '$change',
            '$discount_value',
            '$cs_fullname',
            '$id_number',
            '$discount_type',
            '$date',
            '$user')
    ");

    $transactionId = $conn->insert_id;

    $transactionId = $conn->query("
        SELECT MAX(`transaction_id`) AS `id` FROM `transactions`
    ")->fetch_assoc()["id"];

    //Insert Transactiion items
    for ($i = 0; $i < count($productIds); $i++) {
        
        $product_id = $productIds[$i];
        $productName = $product_name[$i];
        $Quantity = $quantity[$i];
        $Price = isset($price[$i]) ? (float)$price[$i] : 0.0; 
        $sizeid = $size_id[$i];
        $sizeName = $size_name[$i];
        $subtotal = $sub_total[$i];
        $addons_id  =  $addonsId[$i];
        $addons_name = $addonsName[$i];
        $addons_Price = $addons_price[$i];

        $addons_id = isset($addonsId[$i]) ? $addonsId[$i] : 0;
        $addons_name = isset($addonsName[$i]) ? $addonsName[$i] : "";
        $addons_price_val = isset($addons_price[$i]) ? (float)$addons_price[$i] : 0.0;

        $productNameSizeAddons = $productName;
        $productNameSizeAddons .= $sizeName !== "" ? (' / ' . $sizeName) : "";
        $productNameSizeAddons .= $addons_name !== "" ? (' w/ ' . $addons_name) : "";

        $total_price = $Price + $addons_price_val;

        $transaction_items = $conn->query("
            INSERT INTO `transaction_items`
                (
                `transaction_id`, 
                `product_id`,
                `product_name`, 
                `qty`, 
                `price`, 
                `subtotal`)
                    VALUES 
                ('$transactionId',
                '$product_id',
                '$productNameSizeAddons',
                '$Quantity',
                '$total_price',
                '$subtotal')"
        );


        $qtytouse = 0;
        $Result = $conn->query("
         SELECT 
            product_ing.*
         FROM
             product_ingredients product_ing
         WHERE 
             product_ing.size_id = $sizeid
                      
  ");

        while ($row = $Result->fetch_assoc()) {
            $stock_id = $row["stock_id"];
            $qty = $row["quantity"] * $Quantity;
            $qtytouse = $qty;
            $batchSQL = $conn->query("
            SELECT * 
            FROM
                batch 
            WHERE
                archive_status = 0 AND qty > 0 AND expiration_status = 1 AND stock_id = '$stock_id' 
            ORDER BY
                expiration_date
                ASC
        ");

            while ($bt = $batchSQL->fetch_assoc()) {
                $batch_id = $bt["batch_id"];
                $batch_qty = $bt["qty"];

                if ($qtytouse >= $batch_qty) {
                    $conn->query("
                UPDATE `batch`
                SET qty = 0
                WHERE batch_id = $batch_id
            ");

                    $qtytouse -= $batch_qty;
                    continue;
                } else {
                    $conn->query("
                UPDATE `batch`
                SET qty = (qty - $qtytouse)
                WHERE batch_id = $batch_id
            ");
                    $qtytouse = 0;
                    break;
                }
            }


        }
    }

    header("Location: ./print-Reciept.php?transaction=$transactionId");
}
