<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";

$orderBy = isset($_GET["order_by"]) ? $_GET["order_by"] : false;
$orderMethod = ( isset($_GET["order_method"]) and in_array(strtolower($_GET["order_method"]), ["asc", "desc"]) )
    ? $_GET["order_method"] 
    : 'ASC';
$orderQuery = $orderBy ? " ORDER BY $orderBy $orderMethod" : '';

if($request === "sales"){

    $query = " SELECT *
    FROM transactions WHERE 1 ";

    $whereQuery = '';
    $search = isset($_GET["search"]) ? $_GET["search"] : '';
    $id = isset($_GET["id"]) ? $_GET["id"] : '';
    
    $whereQuery .= ($search !== '') ? " AND transaction_id LIKE '%$search%'" : '';
    $whereQuery .= ($id !== '') ? " AND transaction_id = $id" : '';

    $finalquery = $query.$whereQuery.$orderQuery.$limitQuery;
    $result = $conn->query($finalquery);

    $data = []; 
    $transaction_items = [];
    while ($row = $result->fetch_assoc()) {
        $id = $row["transaction_id"];

        $tr_items = $conn->query("
                SELECT *
                FROM transaction_items
                WHERE transaction_id = '$id'
        ");

        while ($tr = $tr_items->fetch_assoc()){
            array_push($transaction_items,[
                "tr_items_id" => $tr["tp_id"],
                "product_id" => $tr["product_id"],
                "product_name" => $tr["product_name"],
                "qty" => $tr["qty"],
                "price" => $tr["price"],
                "subtotal" => $tr["subtotal"]
            ]);
        }

        $data[] = [
            "id" => $row["transaction_id"],
            "total_amount" => $row["total_amount"],
            "amount_tendered" => $row["amount_tendered"],
            "vat_amount" => $row["vat_amount"],
            "vat_sales" => $row["vat_sales"],
            "change_amount" => $row["change_amount"],
            "discount" => $row["discount"],
            "date" => $row["date_created"],
            "transac_items" => $transaction_items,
            "customer_name" => $row["cs_name"],
            "customer_id" => $row["cs_id"],
            "discount_type" => $row["discount_type"],
        ];
    }


    $dataCount = $conn->query("SELECT COUNT(*) AS data_count FROM transactions WHERE 1 $whereQuery")->fetch_assoc()["data_count"];
    $overall_sale = $conn->query("SELECT SUM(total_amount) AS `overall_total` FROM transactions WHERE 1")->fetch_assoc()["overall_total"];
    $cost = $conn->query("SELECT SUM(cost)  AS `cost` FROM batch WHERE archive_status = 0 AND qty > 0")->fetch_assoc()["cost"]; 
    $top_sale = $conn->query("
    SELECT SUM(total) AS top_sale
    FROM (
        SELECT SUM(ti.subtotal) AS total
        FROM transaction_items ti
        INNER JOIN products p ON p.id = ti.product_id
        INNER JOIN transactions tr ON tr.transaction_id = ti.transaction_id
        GROUP BY ti.product_id
        ORDER BY SUM(ti.subtotal) DESC
        LIMIT 7
    ) AS top_7_sales")->fetch_assoc()["top_sale"];
    
    echo json_encode([
        "data" => $data,
        "data_count" => $dataCount,
        "overall_total" => $overall_sale,
        "cost" => $cost,
        "top_sale" => $top_sale
    ]);
}


?>