<?php
    require("../includes/connection.php");
    header("Content-type: application/json");
    
    $request = isset($_GET["request"]) ? $_GET["request"] : '';
    
    $page = isset($_GET["page"]) ? $_GET["page"] : 0;  //returns false if there is no page specified
    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;     //returns 10 if there is no limit specified
    $offset = isset($_GET["offset"]) 
        ? $_GET["offset"]   //returns the offset if specified
        : ( ($page > 0) ? ($page - 1) * $limit : 0);  //returns offset based on the page
    $limitQuery = $page ? " LIMIT $limit OFFSET $offset" : "";

    $orderBy = isset($_GET["order_by"]) ? $_GET["order_by"] : false;
    $orderMethod = ( isset($_GET["order_method"]) and in_array(strtolower($_GET["order_method"]), ["asc", "desc"]) )
        ? $_GET["order_method"] 
        : 'ASC';
    $orderQuery = $orderBy ? " ORDER BY $orderBy $orderMethod" : '';


    if($request === 'products'){
        $query = "
            SELECT * FROM (
        SELECT p.*,
                c.category_name, 
                u.username
            FROM products p
            INNER JOIN categories c ON p.category = c.id
            INNER JOIN users u ON p.added_by = u.user_id
            ) AS tbl
        ";

        $whereQuery = "WHERE 1=1 AND archive_status = 'unarchived'";
        
        $search = isset($_GET["search"]) ? $_GET["search"] : '';
        $category = isset($_GET["category"]) ? $_GET["category"] : '';
        $addons = isset($_GET["addons"]) ? $_GET["addons"] : '';
        $id = isset($_GET["id"]) ? $conn->real_escape_string($_GET["id"]) : "";
        // $whereQuery .= $id ? "AND id = '$id'" : '';

        $whereQuery .= ($search !== '') ? " AND product_name LIKE '%$search%'" : '';
        $whereQuery .= ($id !== '') ? " AND id = '$id'" : '';
        $whereQuery .= ($category != '') ? " AND category = '$category'" : '';
        $whereQuery .= ($addons  != '') ? " AND add_ons = '$addons '" : '';
        
        // $whereQuery .= $id ? " AND product_name = '$productName'" : '';
        //add more where queries here

        //combine all the queries
        $finalQuery = $query.$whereQuery.$orderQuery.$limitQuery;

        $result = $conn->query($finalQuery);
        $data = [];
        while($row = $result->fetch_assoc()){
            $productId = $row["id"];
            
            $product_size = [];
            $add_ons = [];
            

            $product_sizeResult = $conn->query("
                SELECT ps.*
                FROM product_size ps
                INNER JOIN products p ON ps.product_id = p.id
                WHERE ps.product_id = '$productId'       
            ");


            $product_addons = $conn->query("
                SELECT ao.*
                FROM add_ons ao
                INNER JOIN products p ON ao.product_id = p.id
                WHERE ao.product_id = '$productId'
            ");

            while($ao = $product_addons->fetch_assoc()){
                array_push($add_ons, [
                    "addons_id" => $ao["addOns_id"],
                    "addons_name" => $ao["addons_name"],
                    "addons_price" => $ao["price"]
                ]);
            }

            while($ps = $product_sizeResult->fetch_assoc()){
                $sizeId = $ps["size_id"];
                $ingredients = [];
                $ingredientsResult = $conn->query("
                    SELECT pi.*, s.stock_name
                    FROM product_ingredients pi 
                        INNER JOIN stocks s ON pi.stock_id = s.stock_id
                    WHERE pi.size_id = '$sizeId'
                ");



                while($ing = $ingredientsResult->fetch_assoc()){
                    array_push($ingredients, [
                        "ingredients" => $ing["id"],
                        "stock_id" => $ing["stock_id"],
                        "stock_name" => $ing["stock_name"],
                        "quantity" => $ing["quantity"]
                        
                    ]);
                }

                array_push($product_size, [
                    "size_id" => $ps["size_id"],
                    "size_name" => $ps["size_name"],
                    "price" => $ps['price'],
                    "size_status" => $ps['size_status'],
                    'ingredients' => $ingredients

                ]);
            }

            $data[] = [
                "id" => (int)$productId,
                "product_name" => $row["product_name"],
                "category_id" => $row["category"],
                "category_name" => $row["category_name"],
                "product_status" => $row["product_status"],
                "size" => $product_size,
                "date_added" => $row["date_added"],
                "product_description" => $row["product_description"],
                "added_by" => $row["username"],
                "archive_status" => $row["archive_status"],
                "add_ons" => $add_ons
                
            ];
        }


        //get total data of the table for pagination
        $totalData = $conn->query($query.$whereQuery)->num_rows;



        
        echo json_encode([
            "data" => $data,
            "data_count" => $totalData
        ]);
    }
    
    
?>