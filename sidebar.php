<?php
    $role = (int)$conn->query("SELECT user_role FROM users WHERE user_id = ".$_SESSION["user_id"])->fetch_assoc()["user_role"];
?>

<!-- SIDEBAR -->
<section id="sidebar">
    <div class="brand">
        <img src="./asset/logo_1.png" class="logo">
    </div>
    <ul class="side-menu top">
        <hr class="hrline" />
        <p class="title">Main</p>
        <li class="<?= $pageLocation === "dashboard.php" ? "active" : ""?>">
            <a class="main-btn" href="dashboard.php">
                <i class="uil uil-apps"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>


        <?php   if($role != 2){   ?>
            <li class="<?= $pageLocation === "pos.php" ? "active" : ""?>">
                <a class="main-btn" href="pos.php">
                    <i class="uil uil-calculator"></i>
                    <span class="text">Point of Sales</span>
                </a>
            </li>
        <?php   }   ?>


        <?php   if($role != 3){   ?>
        <li class="<?= $pageLocation === "ingredients.php" || $pageLocation === "products.php" ? "active" : ""?>">
            <a class="main-btn" href="ingredients.php">
                <i class="uil uil-box"></i>
                <span class="text">Inventory Management</span>
            </a>
        </li>
        <?php   }   ?>



        <?php if($role == 1){ ?>
<li class="<?= $pageLocation === "sales.php" || $pageLocation === "inventory-reports.php" ? "active" : ""?>">
    <a class="main-btn" href="sales.php">
        <i class="uil uil-file-alt"></i>
        <span class="text">Reports</span>
    </a>
</li>
<?php } elseif($role == 2) { ?>
<li class="<?= $pageLocation === "inventory-reports.php" ? "active" : ""?>">
    <a class="main-btn" href="inventory-reports.php">
        <i class="uil uil-file-alt"></i>
        <span class="text">Inventory Reports</span>
    </a>
</li>
<?php } ?>

        <?php   if($role == 1){   ?>
        <li class="<?= $pageLocation === "user-management.php" ? "active" : ""?>">
            <a class="main-btn" href="user-management.php">
                <i class="uil uil-users-alt"></i>
                <span class="text">User Management</span>
            </a>
        </li>
        <?php   }   ?>


        <?php   if($role == 1){   ?>
        <hr class="hrline" />


        <p class="title">Settings</p>
        <li class="<?= $pageLocation === "system-settings.php" || $pageLocation === "category.php" || $pageLocation === "measurement.php" 
            || $pageLocation === "activity-logs.php" || $pageLocation === "archive-ingredients.php" || $pageLocation === "archive-batch.php" 
            || $pageLocation === "archive-products.php" || $pageLocation === "archive-users.php" || $pageLocation === "archive-category.php" 
            || $pageLocation === "archive-measurement.php" ? "active" : ""?>">
            <a class="main-btn" href="system-settings.php">
                <i class="uil uil-setting"></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <?php   }   ?>
    </ul>
    <ul class="side-menu bottom">
        <hr class="hrline" />
        <p class="title">Account</p>
        <li class="<?= $pageLocation === "account.php" ? "active" : ""?>">
            <a class="main-btn" href="account.php" class="account">
                <i class="uil uil-user-circle"></i>
                <span class="text">Account</span>
            </a>
        </li>
        <li>
            <a class="logout" href="#" onclick="modalShow('logoutModal')">
                <i class="uil uil-sign-out-alt"></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->