<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userAllow(1);

include("./includes/log_check.php");
include ("modals.php"); 

$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$user_role = $_SESSION["user_role"];
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$password = $_SESSION["password"];

$systemSQL = $conn->query("SELECT * FROM system WHERE 1");

while ($row = $systemSQL->fetch_assoc()){
    $id = $row["system_id"];
    $store_name = $row["store_name"];
    $address = $row["store_address"];
    $tin_number = $row["tin-number"];
    $contact = $row["contact"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- sweet alert -->
    <script src="./js/sweetalert.min.js"></script>

    <!-- jquery -->
    <script src="./js/jquery.min.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">

    <!-- Bootstrap -->

    <title>System Settings</title>
</head>
<style>
   #content main {
      animation: transitionIn-Y-over 1s;
   }
</style>
<body>
<?php 
$pageLocation = "system-settings.php";
include ("sidebar.php"); 
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
    <main style="overflow: auto; padding: 10px 24px;">
        <div class="head-title">
                <div class="left">
                    <h2>
                    <i class="uil uil-setting"></i>
                    Settings</h2>
                </div>
                        
                <!-- <div class="search-box">
                        <button class="btn-search"><i class="uil uil-search"></i></button>
                        <input type="text" class="input-search" placeholder="Search For...">
                    </div> -->
            </div>

            <div class="settings-buttons">
                <div><button class="active" role="button" onclick="location.href='system-settings.php';setActive(this);">System Settings</button></div>
                <div><button role="button" onclick="location.href='category.php';setActive(this);">Category</button></div>
                <div><button role="button" onclick="location.href='measurement.php';setActive(this);">Measurement</button></div>
                <div><button role="button" onclick="location.href='activity-logs.php';setActive(this);">Activity Logs</button></div>
                <div><button role="button" onclick="location.href='archive-ingredients.php';setActive(this);">Archive</button></div>
            </div>

            <form action="update-form-system-settings.php" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
            <div class="table-data">
                <div class="system-settings">
                    <div style="display: flex; flex-direction: column; width: 500px;">
                        <div class="display-picture">
                            <span>Store Logo:</span>
                                <div class="display-picture-area">
                                    <img src="./asset/logo_1.png" alt="">
                                </div>
                            <button type="button" class="select-picture" onclick="modalShow('changeLogo')">Change Image</button>
                        </div>
              
                        <div style="padding-top: 1rem;">
                            <span>Store Name:</span>
                            <div class="form-group">
                                <input name="store_name" class="form-field" style="border-radius: 6px; text-transform: capitalize;" type="text" 
                                    placeholder="Enter Store Name" value="<?= $store_name ?>">
                            </div>
                        </div>
             
                        <div style="padding-top: 1rem;">
                            <span>Address:</span>
                            <div class="form-group">
                                <input name="address" class="form-field" style="border-radius: 6px; font-size: 12px; text-transform: capitalize;" type="text" 
                                    placeholder="Enter Address" value="<?= $address ?>">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; width: 500px;">
                        <div class="display-picture">
                            <span>Login Background:</span>
                                <div class="display-picture-area">
                                    <img src="./asset/loginBG_1.png" alt="">
                                </div>
                            <button type="button" class="select-picture" onclick="modalShow('changeBackground')">Change Image</button>
                        </div>

                        <div style="padding-top: 1rem">
                            <span>Contact Number:</span>
                            <div class="form-group">
                                <input name="contact" class="form-field" style="border-radius: 6px;" type="text" id="contact" maxlength="13" 
                                    placeholder="09xx-xxx-xxxx" value="<?= $contact?>">
                            </div>
                        </div>

                        <div style="padding-top: 1rem">
                            <span>TIN Number:</span>
                            <div class="form-group" style="gap: .8rem">
                                <input name="tin" class="form-field" style="border-radius: 6px;" type="text" id="tin" maxlength="15" 
                                    placeholder="xxxx-xxxx" value="<?= $tin_number ?>">

                            <div>
                                <button type="submit" class="update-system-btn">Update</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    </form>


                </div>

        
            </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<?= include("./includes/alert_msg.php") ?>
<script src="./js/script.js"></script>

<!-- store-logo -->
<script>
const storeImage = document.querySelector('#store-image');
const inputLogo = document.querySelector('#logo');
const logoArea = document.querySelector('#logo-area');

storeImage.addEventListener('click', function () {
    inputLogo.click(); // Trigger the hidden file input
});

inputLogo.addEventListener('change', function () {
    const image = this.files[0]; // Get the selected file
    const reader = new FileReader();

    reader.onload = () => {
        // Remove any existing images or text in the logoArea
        const allImg = logoArea.querySelectorAll('img');
        const storeText = logoArea.querySelectorAll('.store-text');
        allImg.forEach(item => item.remove());
        storeText.forEach(item => item.remove());

        // Create a new image element and display it
        const imgUrl = reader.result;
        const img = document.createElement('img');
        img.src = imgUrl;
        logoArea.appendChild(img);
        logoArea.classList.add('active'); // Add the active class for styling
        logoArea.dataset.img = image.name; // Store the image name in the data-img attribute
    }

    reader.readAsDataURL(image); // Read the image as a data URL
});
</script>
<!-- store-logo -->


<!-- login-background -->
<script>
const imageLogin = document.querySelector('#login-image');
const inputLogin = document.querySelector('#login');
const loginArea = document.querySelector('#login-area');

imageLogin.addEventListener('click', function () {
    inputLogin.click(); // Trigger the hidden file input
});

inputLogin.addEventListener('change', function () {
    const image = this.files[0]; // Get the selected file
    const reader = new FileReader();

    reader.onload = () => {
        // Remove any existing images or text in the loginArea
        const allImg = loginArea.querySelectorAll('img');
        const loginText = loginArea.querySelectorAll('.login-text');
        allImg.forEach(item => item.remove());
        loginText.forEach(item => item.remove());

        // Create a new image element and display it
        const imgUrl = reader.result;
        const img = document.createElement('img');
        img.src = imgUrl;
        loginArea.appendChild(img);
        loginArea.classList.add('active'); // Add the active class for styling
        loginArea.dataset.img = image.name; // Store the image name in the data-img attribute
    }

    reader.readAsDataURL(image); // Read the image as a data URL
});

</script>
<!-- login-background -->

<!-- contact-number -->
<script>
const contactInput = document.getElementById('contact');

    contactInput.addEventListener('input', (e) => {
      let value = e.target.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
      if (value.length > 4) value = value.slice(0, 4) + '-' + value.slice(4);
      if (value.length > 8) value = value.slice(0, 8) + '-' + value.slice(8);
      e.target.value = value;
});
</script>
<!-- contact-number -->

<!-- TIN-number -->
<script>
const tinInput = document.getElementById('tin');

    tinInput.addEventListener('input', (e) => {
      let value = e.target.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
      if (value.length > 3) value = value.slice(0, 3) + '-' + value.slice(3);
      if (value.length > 7) value = value.slice(0, 7) + '-' + value.slice(7);
      if (value.length > 11) value = value.slice(0, 11) + '-' + value.slice(11);
      e.target.value = value;
});
</script>
<!-- TIN-number -->

</body>
</html>
