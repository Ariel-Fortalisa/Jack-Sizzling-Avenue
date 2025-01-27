<?php
    //update stock status of stock
    // include("connection.php");
    $conn->query("
        UPDATE `stocks` 
        SET `stock_status` = '1' 
        WHERE IFNULL((SELECT SUM(`qty`) FROM `batch` WHERE `batch`.`stock_id` = `stocks`.`stock_id` AND `batch`.`archive_status` = 0), 0) > `crit`;
    ");
    $conn->query("
        UPDATE `stocks` 
        SET `stock_status` = '2' 
      WHERE IFNULL((SELECT SUM(`qty`) FROM `batch` WHERE `batch`.`stock_id` = `stocks`.`stock_id` AND `batch`.`archive_status` = 0), 0) <= `crit`;
    ");
    $conn->query("
        UPDATE `stocks` SET `stock_status` = '3' 
       WHERE IFNULL((SELECT SUM(`qty`) FROM `batch` WHERE `batch`.`stock_id` = `stocks`.`stock_id` AND `batch`.`archive_status` = 0), 0) = 0;
    ");





    //product size update
    $unavailableIngredients = $conn->query("
        SELECT * FROM (
            SELECT 
                pi.size_id, 
                st.stock_name,
                pi.quantity AS ingredients_qty,
                IFNULL((SELECT SUM(qty) FROM batch bt WHERE stock_id = st.stock_id AND bt.archive_status = '0' AND bt.expiration_status = 1), 0) AS stock_qty 
            FROM `product_ingredients` pi
                INNER JOIN stocks st ON pi.stock_id = st.stock_id
        ) AS tbl
        WHERE ingredients_qty > stock_qty;
    ");

    $conn->query("
        UPDATE `product_size` SET `size_status` = 'available' WHERE 1
    ");

    while($row = $unavailableIngredients->fetch_assoc()){
        
        $conn->query("
            UPDATE `product_size` SET `size_status` = 'unavailable' WHERE `size_id` = ".$row["size_id"].";
        ");
    }





    //update product status
    $unavailableSizes = $conn->query("SELECT * FROM product_size WHERE size_status = 'unavailable' GROUP BY product_id");

    $conn->query("
        UPDATE `products` SET `product_status` = 'available' WHERE 1
    ");
    
    while($row = $unavailableSizes->fetch_assoc()){
        $availableCount = $conn->query("SELECT * FROM product_size WHERE product_id = ".$row["product_id"]." AND size_status = 'available'");
        if($availableCount->num_rows <= 0){
            $conn->query("
                UPDATE `products` SET `product_status` = 'unavailable' WHERE `id` = ".$row["product_id"].";
            ");
        }
        
    }

?>