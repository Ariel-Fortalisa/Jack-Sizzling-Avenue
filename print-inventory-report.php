<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userAllow(1);

include("./includes/log_check.php");

$first_name = $_SESSION["first_name"];
$Last_name = $_SESSION["last_name"];

$date = date("Y-m-d H:i:s");
$date_timestamp = strtotime($date);
$dt = date('M. j, Y', $date_timestamp);
$time_part = date('h:i A', $date_timestamp);

$storedetails = $conn->query("SELECT * FROM system WHERE 1");

while ($row = $storedetails->fetch_assoc()) {
  $storeName = $row["store_name"];
  $storeAddress = $row["store_address"];
  $contact = $row["contact"];
}

$stockFilter = isset($_GET["stockFilter"]) ? $_GET["stockFilter"] : "0";
$expiryFilter = isset($_GET["expiryFilter"]) ? $_GET["expiryFilter"] : "0";

$inventory_cost = $conn->query("SELECT SUM(cost)  AS `cost` FROM batch WHERE archive_status = 0 AND qty > 0")->fetch_assoc()["cost"];
$overall_items = $conn->query("SELECT COUNT(*) as overall_items FROM stocks WHERE archive_status = 0")->fetch_assoc()["overall_items"];


$rowCount = 1;
$lowstockCount = 1;
$outofStockCount = 1;
$gd_count = 1;
$nearly_count = 1;
$expired_count = 1;

//string table stocks
$InStocks = "";
$lowStocks = "";
$outofStock = "";
//string table expiry
$GoodBatch = "";
$NearlyExpireBatch = "";
$ExpiredBatch = "";



if ($stockFilter == "0") {
  // in stock status
  $InStockSQL = "SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    WHERE stock.archive_status = 0 AND stock_status = 1";

  $result = $conn->query($InStockSQL);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $item_name = $row["stock_name"];
      $cost = $row["cost"];
      $quantity = $row["quantity"];
      $unit = $row["UOM"];
      $status = $row["stock_status"];

      $cost_parse = number_format($cost, 2);

      if ($status == 1) {
        $status_badge = 'In Stock';
      } else if ($status == 2) {
        $status_badge = 'Low Stock';
      } else if ($status == 3) {
        $status_badge = 'Out of Stock';
      }

      $InStocks .= '
              <tr>
                <td class="text-center">' . $rowCount . '</td>
                <td class="text-left">' . $item_name . '</td>
                <td class="text-right">₱ ' . $cost_parse . '</td>
                <td class="text-center">' . $quantity . ' ' . $unit . '</td>
                <td class="text-center">' . $status_badge . '</td>
              </tr>
          ';

      $rowCount++;
    }
  } else {
    // If no transactions exist today
    $InStocks .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No In Stocks</th>
          </tr>
      ';
  }

  //   low stock
  $LowStockSQL = "SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    WHERE stock.archive_status = 0 AND stock_status = 2";

  $LowStock_result = $conn->query($LowStockSQL);

  if ($LowStock_result->num_rows > 0) {
    while ($rows = $LowStock_result->fetch_assoc()) {
      $lowStock_name = $rows["stock_name"];
      $lowStock_cost = $rows["cost"];
      $lowStock_quantity = $rows["quantity"];
      $lowStock_unit = $rows["UOM"];
      $lowStock_status = $rows["stock_status"];

      $lowStock_cost_parse = number_format($lowStock_cost, 2);

      if ($lowStock_status == 1) {
        $lowStock_status_badge = 'In Stock';
      } else if ($lowStock_status == 2) {
        $lowStock_status_badge = 'Low Stock';
      } else if ($lowStock_status == 3) {
        $lowStock_status_badge = 'Out of Stock';
      }

      $lowStocks .= '
              <tr>
                <td class="text-center">' . $lowstockCount . '</td>
                <td class="text-left">' . $lowStock_name . '</td>
                <td class="text-right">₱ ' . $lowStock_cost_parse . '</td>
                <td class="text-center">' . $lowStock_quantity . ' ' . $lowStock_unit . '</td>
                <td class="text-center">' . $lowStock_status_badge . '</td>
              </tr>
          ';

      $lowstockCount++;
    }
  } else {
    // If no transactions exist today
    $lowStocks .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Low Stocks</th>
          </tr>
      ';
  }

  //   Out of stocks
  $outOfStockSQL = "SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    WHERE stock.archive_status = 0 AND stock_status = 3";

  $outofstock_result = $conn->query($outOfStockSQL);

  if ($outofstock_result->num_rows > 0) {
    while ($out = $outofstock_result->fetch_assoc()) {
      $outofstock_name = $out["stock_name"];
      $outofstock_cost = $out["cost"];
      $outofstock_quantity = $out["quantity"];
      $outofstock_unit = $out["UOM"];
      $outofstock_status = $out["stock_status"];

      $outofstock_cost_parse = number_format($outofstock_cost, 2);


      if ($outofstock_status == 1) {
        $outofstock_badge = 'In Stock';
      } else if ($outofstock_status == 2) {
        $outofstock_badge = 'Low Stock';
      } else if ($outofstock_status == 3) {
        $outofstock_badge = 'Out of Stock';
      }

      $outofStock .= '
              <tr>
                <td class="text-center">' . $outofStockCount . '</td>
                <td class="text-left">' . $outofstock_name . '</td>
                <td class="text-right">₱ ' . $outofstock_cost_parse . ' PHP</td>
                <td class="text-center">' . $outofstock_quantity . ' ' . $outofstock_unit . '</td>
                <td class="text-center">' . $outofstock_badge . '</td>
              </tr>
          ';

      $outofStockCount++;
    }
  } else {
    $outofStock .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Out of Stocks</th>
          </tr>
      ';
  }
} else if ($stockFilter == "1") {
  // in stock status
  $InStockSQL = "SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    WHERE stock.archive_status = 0 AND stock_status = 1";

  $result = $conn->query($InStockSQL);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $item_name = $row["stock_name"];
      $cost = $row["cost"];
      $quantity = $row["quantity"];
      $unit = $row["UOM"];
      $status = $row["stock_status"];

      $cost_parse = number_format($cost, 2);

      if ($status == 1) {
        $status_badge = 'In Stock';
      } else if ($status == 2) {
        $status_badge = 'Low Stock';
      } else if ($status == 3) {
        $status_badge = 'Out of Stock';
      }

      $InStocks .= '
              <tr>
                <td class="text-center">' . $rowCount . '</td>
                <td class="text-left">' . $item_name . '</td>
                <td class="text-right">₱ ' . $cost_parse . '</td>
                <td class="text-center">' . $quantity . ' ' . $unit . '</td>
                <td class="text-center">' . $status_badge . '</td>
              </tr>
          ';

      $rowCount++;
    }
  } else {
    $InStocks .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No In Stocks</th>
          </tr>
      ';
  }
} else if ($stockFilter == "2") {
  //   low stock
  $LowStockSQL = "SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    WHERE stock.archive_status = 0 AND stock_status = 2";

  $LowStock_result = $conn->query($LowStockSQL);

  if ($LowStock_result->num_rows > 0) {
    while ($rows = $LowStock_result->fetch_assoc()) {
      $lowStock_name = $rows["stock_name"];
      $lowStock_cost = $rows["cost"];
      $lowStock_quantity = $rows["quantity"];
      $lowStock_unit = $rows["UOM"];
      $lowStock_status = $rows["stock_status"];

      $lowStock_cost_parse = number_format($lowStock_cost, 2);

      if ($lowStock_status == 1) {
        $lowStock_status_badge = 'In Stock';
      } else if ($lowStock_status == 2) {
        $lowStock_status_badge = 'Low Stock';
      } else if ($lowStock_status == 3) {
        $lowStock_status_badge = 'Out of Stock';
      }

      $lowStocks .= '
              <tr>
                <td class="text-center">' . $lowstockCount . '</td>
                <td class="text-left">' . $lowStock_name . '</td>
                <td class="text-right">₱ ' . $lowStock_cost_parse . '</td>
                <td class="text-center">' . $lowStock_quantity . ' ' . $lowStock_unit . '</td>
                <td class="text-center">' . $lowStock_status_badge . '</td>
              </tr>
          ';

      $lowstockCount++;
    }
  } else {
    $lowStocks .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Low Stocks</th>
          </tr>
      ';
  }
} else if ($stockFilter == "3") {
  //   Out of stocks
  $outOfStockSQL = "SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    WHERE stock.archive_status = 0 AND stock_status = 3";

  $outofstock_result = $conn->query($outOfStockSQL);

  if ($outofstock_result->num_rows > 0) {
    while ($out = $outofstock_result->fetch_assoc()) {
      $outofstock_name = $out["stock_name"];
      $outofstock_cost = $out["cost"];
      $outofstock_quantity = $out["quantity"];
      $outofstock_unit = $out["UOM"];
      $outofstock_status = $out["stock_status"];

      $outofstock_cost_parse = number_format($outofstock_cost, 2);


      if ($outofstock_status == 1) {
        $outofstock_badge = 'In Stock';
      } else if ($outofstock_status == 2) {
        $outofstock_badge = 'Low Stock';
      } else if ($outofstock_status == 3) {
        $outofstock_badge = 'Out of Stock';
      }

      $outofStock .= '
              <tr>
                <td class="text-center">' . $outofStockCount . '</td>
                <td class="text-left">' . $outofstock_name . '</td>
                <td class="text-right">₱ ' . $outofstock_cost_parse . ' PHP</td>
                <td class="text-center">' . $outofstock_quantity . ' ' . $outofstock_unit . '</td>
                <td class="text-center">' . $outofstock_badge . '</td>
              </tr>
          ';

      $outofStockCount++;
    }
  } else {
    // If no transactions exist today
    $outofStock .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Out of Stocks</th>
          </tr>
      ';
  }
} else {
  // in stock status
  $InStockSQL = "SELECT *,
(SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
 unit_of_measurement.unit_id,
 unit_of_measurement.unit_name AS UOM
 FROM stocks stock
 INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
 WHERE stock.archive_status = 0 AND stock_status = 1";

  $result = $conn->query($InStockSQL);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $item_name = $row["stock_name"];
      $cost = $row["cost"];
      $quantity = $row["quantity"];
      $unit = $row["UOM"];
      $status = $row["stock_status"];

      if ($status == 1) {
        $status_badge = 'In Stock';
      } else if ($status == 2) {
        $status_badge = 'Low Stock';
      } else if ($status == 3) {
        $status_badge = 'Out of Stock';
      }

      $InStocks .= '
           <tr>
             <td class="text-center">' . $rowCount . '</td>
             <td class="text-left">' . $item_name . '</td>
             <td class="text-center">' . $cost . ' PHP</td>
             <td class="text-center">' . $quantity . ' ' . $unit . '</td>
             <td class="text-center">' . $status_badge . '</td>
           </tr>
       ';

      $rowCount++;
    }
  } else {
    // If no transactions exist today
    $InStocks .= '
       <tr>
           <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No In Stocks</th>
       </tr>
   ';
  }

  //   low stock
  $LowStockSQL = "SELECT *,
(SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
 unit_of_measurement.unit_id,
 unit_of_measurement.unit_name AS UOM
 FROM stocks stock
 INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
 WHERE stock.archive_status = 0 AND stock_status = 2";

  $LowStock_result = $conn->query($LowStockSQL);

  if ($LowStock_result->num_rows > 0) {
    while ($rows = $LowStock_result->fetch_assoc()) {
      $lowStock_name = $rows["stock_name"];
      $lowStock_cost = $rows["cost"];
      $lowStock_quantity = $rows["quantity"];
      $lowStock_unit = $rows["UOM"];
      $lowStock_status = $rows["stock_status"];

      if ($lowStock_status == 1) {
        $lowStock_status_badge = 'In Stock';
      } else if ($lowStock_status == 2) {
        $lowStock_status_badge = 'Low Stock';
      } else if ($lowStock_status == 3) {
        $lowStock_status_badge = 'Out of Stock';
      }

      $lowStocks .= '
           <tr>
             <td class="text-center">' . $lowstockCount . '</td>
             <td class="text-left">' . $lowStock_name . '</td>
             <td class="text-center">' . $lowStock_cost . '</td>
             <td class="text-center">' . $lowStock_quantity . ' ' . $lowStock_unit . '</td>
             <td class="text-center">' . $lowStock_status_badge . '</td>
           </tr>
       ';

      $lowstockCount++;
    }
  } else {
    // If no transactions exist today
    $lowStocks .= '
       <tr>
           <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Low Stocks</th>
       </tr>
   ';
  }

  //   Out of stocks
  $outOfStockSQL = "SELECT *,
(SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
 unit_of_measurement.unit_id,
 unit_of_measurement.unit_name AS UOM
 FROM stocks stock
 INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
 WHERE stock.archive_status = 0 AND stock_status = 3";

  $outofstock_result = $conn->query($outOfStockSQL);

  if ($outofstock_result->num_rows > 0) {
    while ($out = $outofstock_result->fetch_assoc()) {
      $outofstock_name = $out["stock_name"];
      $outofstock_cost = $out["cost"];
      $outofstock_quantity = $out["quantity"];
      $outofstock_unit = $out["UOM"];
      $outofstock_status = $out["stock_status"];

      if ($outofstock_status == 1) {
        $outofstock_badge = 'In Stock';
      } else if ($outofstock_status == 2) {
        $outofstock_badge = 'Low Stock';
      } else if ($outofstock_status == 3) {
        $outofstock_badge = 'Out of Stock';
      }

      $outofStock .= '
           <tr>
             <td class="text-center">' . $outofStockCount . '</td>
             <td class="text-left">' . $outofstock_name . '</td>
             <td class="text-center">' . $outofstock_cost . ' PHP</td>
             <td class="text-center">' . $outofstock_quantity . ' ' . $outofstock_unit . '</td>
             <td class="text-center">' . $outofstock_badge . '</td>
           </tr>
       ';

      $outofStockCount++;
    }
  } else {
    // If no transactions exist today
    $outofStock .= '
       <tr>
           <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Out of Stocks</th>
       </tr>
   ';
  }
}

//expiry
if ($expiryFilter == '1') {
  $batchSql = " SELECT 
        batch.batch_id, 
        batch.stock_id, 
        batch.qty, 
        batch.cost, 
        batch.expiration_date, 
        batch.expiration_status, 
        batch.archive_status,
        stocks.stock_name
    FROM batch
    INNER JOIN stocks ON batch.stock_id = stocks.stock_id
    WHERE batch.archive_status = 0 AND batch.qty > 0 AND expiration_status = 1 
    ORDER BY expiration_date ASC";
  $good_result = $conn->query($batchSql);

  if ($good_result->num_rows > 0) {
    while ($good = $good_result->fetch_assoc()) {
      $gd_name = $good["stock_name"];
      $gd_id = $good["batch_id"];
      $gd_cost = $good["cost"];
      $gd_date = $good["expiration_date"];

      $gd_cost_parse = number_format($gd_cost, 2);

      $date = date_create($gd_date);
      $date_formated = date_format($date, "m-d-Y");

      $GoodBatch .= '
        <tr>
            <td class="text-center">' . $gd_count . '</td>
            <td class="text-left">' . $gd_name . '</td>
            <td class="text-right">₱ ' . $gd_cost_parse . '</td>
            <td class="text-center">' . $gd_id . '</td>
            <td class="text-center">' . $date_formated . '</td>
        </tr>
      
      ';
      $gd_count++;
    }
  } else {
    // If no transactions exist today
    $GoodBatch .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Good Batches</th>
          </tr>
      ';
  }
} else if ($expiryFilter == '2') {
  $Nearly_batchSql = " SELECT 
  batch.batch_id, 
  batch.stock_id, 
  batch.qty, 
  batch.cost, 
  batch.expiration_date, 
  batch.expiration_status, 
  batch.archive_status,
  stocks.stock_name
FROM batch
INNER JOIN stocks ON batch.stock_id = stocks.stock_id
WHERE batch.archive_status = 0 AND batch.qty > 0 AND expiration_status = 2 
ORDER BY expiration_date ASC";
  $Nearly_result = $conn->query($Nearly_batchSql);

  if ($Nearly_result->num_rows > 0) {
    while ($Nearly_expire = $Nearly_result->fetch_assoc()) {
      $Nearly_name = $Nearly_expire["stock_name"];
      $Nearly_id = $Nearly_expire["batch_id"];
      $nearly_cost = $Nearly_expire["cost"];
      $Nearly_date = $Nearly_expire["expiration_date"];

      $Nearly_created = date_create($Nearly_date);
      $Nearly_date_formated = date_format($Nearly_created, "m-d-Y");

      $nearly_cost_parse = number_format($nearly_cost, 2);

      $NearlyExpireBatch .= '
  <tr>
      <td class="text-center">' . $nearly_count . '</td>
      <td class="text-left">' . $Nearly_name . '</td>
      <td class="text-right">₱ ' . $nearly_cost_parse . '</td>
      <td class="text-center">' . $Nearly_id . '</td>
      <td class="text-center">' . $Nearly_date_formated . '</td>
  </tr>

';
      $nearly_count++;
    }
  } else {
    // If no transactions exist today
    $NearlyExpireBatch .= '
    <tr>
        <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Good Batches</th>
    </tr>
';
  }
} else if ($expiryFilter == '3') {
  $expired_batchSql = " SELECT 
  batch.batch_id, 
  batch.stock_id, 
  batch.qty, 
  batch.cost, 
  batch.expiration_date, 
  batch.expiration_status, 
  batch.archive_status,
  stocks.stock_name
FROM batch
INNER JOIN stocks ON batch.stock_id = stocks.stock_id
WHERE batch.archive_status = 0 AND batch.qty > 0 AND expiration_status = 3 
ORDER BY expiration_date ASC";
  $expired_result = $conn->query($expired_batchSql);

  if ($expired_result->num_rows > 0) {
    while ($exp = $expired_result->fetch_assoc()) {
      $expired_name = $exp["stock_name"];
      $expired_id = $exp["batch_id"];
      $exp_date = $exp["expiration_date"];
      $expired_cost = $exp["cost"];

      $expired_date = date_create($exp_date);
      $exp_format = date_format($expired_date, "m-d-Y");

      $expire_cost_parse = number_format($expired_cost, 2);

      $ExpiredBatch .= '
        <tr>
            <td class="text-center">' . $expired_count . '</td>
            <td class="text-left">' . $expired_name . '</td>
            <td class="text-right">₱ ' . $expire_cost_parse . '</td>
            <td class="text-center">' . $expired_id . '</td>
            <td class="text-center">' . $exp_format . '</td>
        </tr>
    ';
      $expired_count++;
    }
  } else {
    // If no transactions exist today
    $ExpiredBatch .= '
      <tr>
          <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Good Batches</th>
      </tr>
  ';
  }
} else {
  $batchSql = " SELECT 
        batch.batch_id, 
        batch.stock_id, 
        batch.qty, 
        batch.cost, 
        batch.expiration_date, 
        batch.expiration_status, 
        batch.archive_status,
        stocks.stock_name
    FROM batch
    INNER JOIN stocks ON batch.stock_id = stocks.stock_id
    WHERE batch.archive_status = 0 AND batch.qty > 0 AND expiration_status = 1 
    ORDER BY expiration_date ASC";
  $good_result = $conn->query($batchSql);

  if ($good_result->num_rows > 0) {
    while ($good = $good_result->fetch_assoc()) {
      $gd_name = $good["stock_name"];
      $gd_id = $good["batch_id"];
      $gd_cost = $good["cost"];
      $gd_date = $good["expiration_date"];

      $gd_cost_parse = number_format($gd_cost, 2);

      $date = date_create($gd_date);
      $date_formated = date_format($date, "m-d-Y");

      $GoodBatch .= '
        <tr>
            <td class="text-center">' . $gd_count . '</td>
            <td class="text-left">' . $gd_name . '</td>
            <td class="text-right">₱ ' . $gd_cost_parse . '</td>
            <td class="text-center">' . $gd_id . '</td>
            <td class="text-center">' . $date_formated . '</td>
        </tr>
      
      ';
      $gd_count++;
    }
  } else {
    // If no transactions exist today
    $GoodBatch .= '
          <tr>
              <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Good Batches</th>
          </tr>
      ';
  }

  $Nearly_batchSql = " SELECT 
  batch.batch_id, 
  batch.stock_id, 
  batch.qty, 
  batch.cost, 
  batch.expiration_date, 
  batch.expiration_status, 
  batch.archive_status,
  stocks.stock_name
FROM batch
INNER JOIN stocks ON batch.stock_id = stocks.stock_id
WHERE batch.archive_status = 0 AND batch.qty > 0 AND expiration_status = 2 
ORDER BY expiration_date ASC";
  $Nearly_result = $conn->query($Nearly_batchSql);

  if ($Nearly_result->num_rows > 0) {
    while ($Nearly_expire = $Nearly_result->fetch_assoc()) {
      $Nearly_name = $Nearly_expire["stock_name"];
      $Nearly_id = $Nearly_expire["batch_id"];
      $nearly_cost = $Nearly_expire["cost"];
      $Nearly_date = $Nearly_expire["expiration_date"];

      $Nearly_created = date_create($Nearly_date);
      $Nearly_date_formated = date_format($Nearly_created, "m-d-Y");

      $nearly_cost_parse = number_format($nearly_cost, 2);

      $NearlyExpireBatch .= '
  <tr>
      <td class="text-center">' . $nearly_count . '</td>
      <td class="text-left">' . $Nearly_name . '</td>
      <td class="text-right">₱ ' . $nearly_cost_parse . '</td>
      <td class="text-center">' . $Nearly_id . '</td>
      <td class="text-center">' . $Nearly_date_formated . '</td>
  </tr>

';
      $nearly_count++;
    }
  } else {
    // If no transactions exist today
    $NearlyExpireBatch .= '
    <tr>
        <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Good Batches</th>
    </tr>
';
  }

  $expired_batchSql = " SELECT 
  batch.batch_id, 
  batch.stock_id, 
  batch.qty, 
  batch.cost, 
  batch.expiration_date, 
  batch.expiration_status, 
  batch.archive_status,
  stocks.stock_name
FROM batch
INNER JOIN stocks ON batch.stock_id = stocks.stock_id
WHERE batch.archive_status = 0 AND batch.qty > 0 AND expiration_status = 3 
ORDER BY expiration_date ASC";
  $expired_result = $conn->query($expired_batchSql);

  if ($expired_result->num_rows > 0) {
    while ($exp = $expired_result->fetch_assoc()) {
      $expired_name = $exp["stock_name"];
      $expired_id = $exp["batch_id"];
      $exp_date = $exp["expiration_date"];
      $expired_cost = $exp["cost"];

      $expired_date = date_create($exp_date);
      $exp_format = date_format($expired_date, "m-d-Y");

      $expire_cost_parse = number_format($expired_cost, 2);

      $ExpiredBatch .= '
        <tr>
            <td class="text-center">' . $expired_count . '</td>
            <td class="text-left">' . $expired_name . '</td>
            <td class="text-right">₱ ' . $expire_cost_parse . '</td>
            <td class="text-center">' . $expired_id . '</td>
            <td class="text-center">' . $exp_format . '</td>
        </tr>
    ';
      $expired_count++;
    }
  } else {
    // If no transactions exist today
    $ExpiredBatch .= '
      <tr>
          <th colspan="5" class="text-center" style="height: 350px; vertical-align: middle">No Good Batches</th>
      </tr>
  ';
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Jquery -->
  <script src="./js/jquery.min.js"></script>

  <!-- chart js -->
  <script src="./js/chart.js"></script>

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="./bootstrap/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="./bootstrap/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>



  <!-- Unicons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  <!-- My CSS -->
  <!-- <link rel="stylesheet" href="./css/tablestyle.css">
  <link rel="stylesheet" href="style.css"> -->

  <!-- Page Transition -->
  <link rel="stylesheet" href="page_transition.css">

  <title>Sales Report</title>



</head>
<style>
  /* .row {
    display: flex;                
    justify-content: space-between; 
    margin-top: 20px;             /
}

    .col {
        padding: 0 10px;            
    }

    .col-7 {
        flex: 0 0 70%;               
    }

    .col-5 {
        flex: 0 0 30%;                
    } */

  .store-logo {
    width: 200px;
    height: 90px;
    margin: 0 auto;
    display: block;
    margin-bottom: 10px;

  }

  p {
    padding: 0;
    margin: 0;
  }

  .title-report {
    text-align: center;
  }

  @page {
    size: A4;
  }

  @media print {

    html,
    body {
      width: 210mm;
      height: 297mm;
    }

    .page {
      margin: 0;
      border: initial;
      border-radius: initial;
      width: initial;
      min-height: initial;
      box-shadow: initial;
      background: initial;
      page-break-after: always;
    }
  }

  body {
    margin: 0;
    padding: 0;
    font-family: "Work Sans", sans-serif;
  }

  .page {
    margin: auto;
    width: 210mm;
    /*height: 297mm;
        border: 1px solid lightgray;*/
  }
</style>

<body>


  <div id="buttonDiv" style="margin: 30px auto; display: flex; justify-content: center">
    <a href="./inventory-reports.php"><button type="button" class="btn btn-secondary m-3">Back</button></a>
    <div class="add-stock"><button type="button" class="btn btn-primary m-3" onclick="hideButtons()">Print</button></div>
  </div>
  <!-- All table -->
  <div class="page" id="inStock_table">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Inventory Reports</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col col-7 d-flex align-items-center">
        <!-- stock in -->
        <h5></h5>
      </div>
      <div class="col col-5">
        <p><b>Inventory Cost:&emsp;</b>₱ <?= number_format($inventory_cost, 2) ?></p>
        <p><b>Total Inventory Items:&emsp;</b><?= $overall_items ?> items</p>
      </div>
    </div>
    <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">ITEM</th>
          <th class="text-center">COST</th>
          <th class="text-center">QUANTITY</th>
          <th class="text-center">STATUS</th>
        </tr>
      </thead>
      <tbody>
        <?= $InStocks ?>
      </tbody>
    </table>
  </div>
  <!-- stock in -->

  <!-- low stocks -->
  <div class="page" id="lowStock_table">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Inventory Reports</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <table class="table" style="width: 100%; margin-top: 20px;">
      <thead>
        <th class="text-center">#</th>
        <th class="text-center">ITEM</th>
        <th class="text-center">COST</th>
        <th class="text-center">QUANTITY</th>
        <th class="text-center">STATUS</th>
      </thead>
      <tbody>
        <?= $lowStocks ?>
      </tbody>
    </table>
  </div>
  <!-- low stocks -->


  <!-- Out of Stocks -->
  <div class="page" id="OutOfStock_table">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Inventory Reports</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <table class="table" style="width: 100%; margin-top: 20px;">
      <thead>
        <th class="text-center">#</th>
        <th class="text-center">ITEM</th>
        <th class="text-center">COST</th>
        <th class="text-center">QUANTITY</th>
        <th class="text-center">STATUS</th>
      </thead>
      <tbody>
        <?= $outofStock ?>
      </tbody>
    </table>
  </div>
  <!-- Out of Stocks -->
  <!-- All tables -->

  <!-- expiry table -->
  <!-- Good table -->
  <div class="page" id="GoodBatch_table">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Good Batch</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col col-7 d-flex align-items-center">
        <!-- Expiry header -->
        <h5></h5>
      </div>
      <div class="col col-5">
      </div>
    </div>
    <table class="table" style="width: 100%; margin-top: 20px;">
      <thead>
        <th class="text-center">#</th>
        <th class="text-center">ITEM</th>
        <th class="text-center">COST</th>
        <th class="text-center">BATCH ID</th>
        <th class="text-center">EXPIRATION</th>
      </thead>
      <tbody>
        <?= $GoodBatch ?>
      </tbody>
    </table>
  </div>
  <!-- Good table -->

  <!-- Nearly Expire -->
  <div class="page" id="NearlyExpire_table">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Nearly Expire Batch</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <table class="table" style="width: 100%; margin-top: 20px;">
      <thead>
        <th class="text-center">#</th>
        <th class="text-center">ITEM</th>
        <th class="text-center">COST</th>
        <th class="text-center">BATCH ID</th>
        <th class="text-center">EXPIRATION</th>
      </thead>
      <tbody>
        <?= $NearlyExpireBatch ?>
      </tbody>
    </table>
  </div>
  <!-- Nearly Expire -->

  <!-- Expired table -->
  <div class="page" id="Expired_table">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Expired Batch</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <table class="table" style="width: 100%; margin-top: 20px;">
      <thead>
        <th class="text-center">#</th>
        <th class="text-center">ITEM</th>
        <th class="text-center">COST</th>
        <th class="text-center">BATCH ID</th>
        <th class="text-center">EXPIRATION</th>
      </thead>
      <tbody>
        <?= $ExpiredBatch ?>
      </tbody>
    </table>
  </div>
  <!-- Expired table -->

  <!-- expiry table -->

</body>

<script>
  function hideButtons() {
    $("#buttonDiv").css("display", "none");
    window.print();
    $("#buttonDiv").css("display", "flex");
  }
</script>
<script>
  $(document).ready(function() {

    $('#inStock_table').hide();
    $('#lowStock_table').hide();
    $('#OutOfStock_table').hide();

    if (<?= $stockFilter ?> == "1") {
      $('#inStock_table').show();
    } else if (<?= $stockFilter ?> == "2") {
      $('#lowStock_table').show();
    } else if (<?= $stockFilter ?> == "3") {
      $('#OutOfStock_table').show();
    } else {
      $('#inStock_table').show();
      $('#lowStock_table').show();
      $('#OutOfStock_table').show();
    }

    $('#GoodBatch_table').hide();
    $('#NearlyExpire_table').hide();
    $('#Expired_table').hide();

    if (<?= $expiryFilter ?> == "1") {
      $('#GoodBatch_table').show();
    } else if (<?= $expiryFilter ?> == "2") {
      $('#NearlyExpire_table').show();
    } else if (<?= $expiryFilter ?> == "3") {
      $('#Expired_table').show();
    } else {
      $('#GoodBatch_table').show();
      $('#NearlyExpire_table').show();
      $('#Expired_table').show();
    }




  });
</script>

</html>