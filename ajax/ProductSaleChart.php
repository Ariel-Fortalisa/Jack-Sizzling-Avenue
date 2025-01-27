<?php
header('Content-Type: application/json');
include('../includes/connection.php');
date_default_timezone_set('Asia/Manila');

$tb = isset($_GET["sort"]) ? $_GET["sort"] : "top";

$sort = ($tb == "top") ? "DESC" : "ASC";

$data = [];

    $sql = $conn->query("
        SELECT ti.tp_id, p.product_name, SUM(ti.subtotal) AS total
        FROM transaction_items ti
            INNER JOIN products p ON p.id = ti.product_id
            INNER JOIN transactions tr ON tr.transaction_id = ti.transaction_id
        WHERE 1
        GROUP BY
            ti.product_id
        ORDER BY
            total $sort
        LIMIT 7
    ");

    while ($row = $sql->fetch_assoc()) {
        $data[] = [
            "product_name" => $row["product_name"],
            "total" => (float)$row["total"]
        ];
    }

echo json_encode([
    "data" => $data
]);
