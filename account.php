<?php
session_start();
include("./includes/connection.php");
include("./includes/log_check.php");
// include ("./includes/checkRole.php");
include("modals.php");
date_default_timezone_set('Asia/Manila');


$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$user_role = $_SESSION["user_role"];
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$password = $_SESSION["password"];

$userSQL = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
$userRow = $userSQL->fetch_assoc();
$currentSecurityQuestionID = $userRow['security_question1'];
$currentAnswer = $userRow['answer_1'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- sweetalert -->
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



    <title>Account Details</title>
</head>
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col {
        flex: 1;
        padding: 10px;
    }

    .col-50 {
        flex: 0 0 50%;
    }

    .col-100 {
        flex: 0 0 100%;
    }

    #content main {
        animation: transitionIn-Y-over 1s;
    }
</style>

<body>
    <?php
    $pageLocation = "account.php";
    include("sidebar.php");
    ?>
    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Jack Sizzling Avenue</a>

            <a href="#" class="profile">
                <img src="./upload/user_dp/user_<?= $user_id ?>.png">
            </a>
        </nav>
        <!-- NAVBAR -->




        <!-- MAIN -->
        <main style="overflow: auto;">
            <div class="head-title">
                <div class="left">
                    <h2>
                        <i class="uil uil-user-circle"></i>
                        My Account
                    </h2>
                </div>
            </div>

            <div class="table-data" style="margin-top: 40px">
                <div class="account-details">
                    <div style="display: flex; flex-direction: column; width: 500px;">
                        <div class="display-profile">
                            <span>Profile:</span>
                            <div class="display-profile-area">
                                <img src="./upload/user_dp/user_<?= $user_id ?>.png" alt="">
                            </div>
                            <button type="button" class="select-profile" onclick="modalShow('changeProfile')">Change Profile</button>
                        </div>
                    </div>

                    <form action="update-user-account.php" method="POST">
                        <div style="display: flex; flex-direction: column; width: 400px;">

                            <div class="row" style="margin-left: -10px;">
                                <div class="col">
                                    <div style="padding-top: 1.8rem">
                                        <span>First Name:</span>
                                        <div class="form-group">
                                            <input class="form-field" name="first_name" style="border-radius: 6px;" type="text"
                                                placeholder="Enter Firstname" value="<?= $firstname ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div style="padding-top: 1.8rem">
                                        <span>Last Name:</span>
                                        <div class="form-group">
                                            <input class="form-field" name="last_name" style="border-radius: 6px;" type="text"
                                                placeholder="Enter Lastname" value="<?= $lastname ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="padding-top: 1rem">
                                <span>Username:</span>
                                <div class="form-group">
                                    <input class="form-field" name="username" style="border-radius: 6px;" type="text"
                                        placeholder="Enter Username" value="<?= $username ?>" required>
                                </div>
                            </div>

                            <div style="padding-top: 1.8rem">
                                <span>New Password:</span>
                                <div class="form-group">
                                    <input name="new_password" id="new_password" class="form-field" style="border-radius: 6px;" type="password" id="password"
                                        placeholder="Enter Password" value="">
                                </div>
                            </div>

                            <div style="padding-top: 1.8rem">
                                <span>Security Question:</span>
                                <div class="form-group">
                                    <select class="form-field" name="security_question" id="security_question" style="border-radius: 6px;" required>
                                        <?php
                                        $SQL = $conn->query("SELECT * FROM security_question WHERE 1");
                                        while ($row = $SQL->fetch_assoc()) {
                                            $selected = ($row["id"] == $currentSecurityQuestionID) ? 'selected' : '';
                                            echo '
                                          <option value="' . $row["id"] . '" ' . $selected . ' style="font-size: 14px;">' . $row["list_question"] . '</option>
                                         ';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div style="padding-top: 1.8rem">
                                <span>Answer:</span>
                                <div class="form-group">
                                    <input name="answer" id="answer" class="form-field" style="border-radius: 6px;" type="text" id="password"
                                        placeholder="Enter Password" value="<?= $currentAnswer ?>" required>
                                </div>
                            </div>


                            <div style="padding-top: 1.8rem">
                                <hr>
                                <span>Previous Password:</span>
                                <div class="form-group">
                                    <input name="old_password" id="old_password" class="form-field" style="border-radius: 6px;" type="password" id="password"
                                        placeholder="Enter Password" value="" required>
                                </div>
                                <div style="color: gray; font-style: italic; font-size: small;">Note: once you enter your previous password it will update all the details you change</div>

                            </div>

                            <div style="display: flex; flex-direction: row-reverse; align-self: flex-end; margin-top: 10px">
                                <button type="submit" onclick="" class="update-details-btn">Update</button>
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

    <!-- profile-picture -->
    <script>
        const accountprofileImage = document.querySelector('#account-profile-image');
        const inputAccountProfile = document.querySelector('#account-profile');
        const accountprofileArea = document.querySelector('#account-profile-area');

        accountprofileImage.addEventListener('click', function() {
            inputAccountProfile.click(); // Trigger the hidden file input
        });

        inputAccountProfile.addEventListener('change', function() {
            const image = this.files[0]; // Get the selected file
            const reader = new FileReader();

            reader.onload = () => {
                // Remove any existing images or text in the accountprofileArea
                const allImg = accountprofileArea.querySelectorAll('img');
                const profileText = accountprofileArea.querySelectorAll('.account-text');
                allImg.forEach(item => item.remove());
                profileText.forEach(item => item.remove());

                // Create a new image element and display it
                const imgUrl = reader.result;
                const img = document.createElement('img');
                img.src = imgUrl;
                accountprofileArea.appendChild(img);
                accountprofileArea.classList.add('active'); // Add the active class for styling
                accountprofileArea.dataset.img = image.name; // Store the image name in the data-img attribute
            }

            reader.readAsDataURL(image); // Read the image as a data URL
        });
    </script>
    <!-- profile-picture -->


    <!-- password-toggle 
    <script>
        const viewPassword = (accountPass, passEye) => {
            const input = document.getElementById(accountPass),
                iconEye = document.getElementById(passEye);

            iconEye.addEventListener('click', () => {
                // Toggle password visibility
                input.type = input.type === 'password' ? 'text' : 'password';

                // Toggle the eye icon class
                iconEye.classList.toggle('uil-eye');
                iconEye.classList.toggle('uil-eye-slash');
            });
        };
        viewPassword('password', 'accountPassword');
    </script>
    <!-- password-toggle -->

    <script>
        function validatePasswords() {
            var oldPassword = document.getElementById('old_password').value;
            var errorMessage = document.getElementById('wrong_password');
            $.ajax({
                url: './ajax/validate-password.php',
                type: 'POST',
                data: {
                    old_password: oldPassword
                },
                success: function(response) {
                    if (response == 'valid') {
                        // Allow the form to submit
                        return true;
                    } else if (response == 'invalid') {
                        // Display error message if password is incorrect
                        errorMessage.style.display = 'block';
                        return false; // Prevent form submission
                    }
                }
            });
            return false;
        }
    </script>

</body>

</html>