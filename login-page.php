<?php
session_start();
include('includes/connection.php');

$error_message = '';

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if (isset($_POST['login'])) {
   $user = $_POST['username'];
   $password = $_POST['password'];

   // Prepare the SQL statement with placeholders and use prepared statements
   $sql = "SELECT user_id, first_name, last_name, username, password, user_role, archive_status FROM users WHERE username = '$user'";
   $result = $conn->query($sql);

   if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      if ($row['archive_status'] == 1) {
         $_SESSION["warning_message"] = 'Your account is archived. Please contact the admin.';
         header('Location: login-page.php');
         exit;
      }

      // Check the password
      if (password_verify($password, $row['password'])) {
         $user_ID = $row["user_id"];
         $_SESSION["user_id"] = $row["user_id"];
         $_SESSION["first_name"] = $row["first_name"];
         $_SESSION["last_name"] = $row["last_name"];
         $_SESSION["user_role"] = $row["user_role"];
         $_SESSION["password"] = $row["password"];
         $_SESSION["username"] = $user;

         // Log the activity
         $conn->query("
            INSERT INTO `activity_logs`
            (`activity_logs`, `date_created`, `added_by`) 
            VALUES 
            ('Login to the system.',
            '$date',
            '$user_ID')");

         // Redirect based on user role
         if ($row["user_role"] == 1) {
            header('Location: ./dashboard.php');
         } else if ($row["user_role"] == 2) {
            header('Location: ./dashboard.php');
         } else if ($row["user_role"] == 3) {
            header('Location: ./dashboard.php');
         }
         exit;
      } else {
         
         $error_message = 'Invalid Username or Password';
      }
   } else {
      $error_message = 'Invalid Username or Password';
   }
}

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

   <!--=============== CSS ===============-->
   <link rel="stylesheet" href="./css/login.css">

   <title>Login Account</title>
</head>

<body>

   <!--=============== LOGIN IMAGE ===============-->
   <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
      <mask id="mask0" mask-type="alpha">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"
            transform="scale(1.5, 1.2) translate(-50, -30)" />
      </mask>

      <g mask="url(#mask0)">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />

         <!-- Insert your image (recommended size: 1000 x 1200) -->
         <image class="login__img" href="./asset/loginBG_1.png" />
      </g>
   </svg>

   <!--=============== LOGIN ===============-->
   <div class="login container grid" id="loginAccessRegister">
      <!--===== LOGIN ACCESS =====-->
      <div class="login__access">
         <div class="login__logo">
            <img src="./asset/logo_1.png" alt="Logo" class="logo">
         </div>

         <h2 class="login__title">Log in your account.</h2>

         <div class="login__area">
            <form action="" method="POST" class="login__form">
               <div class="login__content grid">
                  <div class="login__box">
                     <input name="username" id="username" type="text" id="text" required placeholder=" " class="login__input">
                     <label for="username" class="login__label">Username</label>

                     <i class="uil uil-user-circle login__icon"></i>
                  </div>

                  <div class="login__box">
                     <input type="password" name="password" id="password" required placeholder=" " class="login__input">
                     <label for="password" class="login__label">Password</label>

                     <i class="uil uil-eye-slash login__icon login__password" id="loginPassword"></i>
                  </div>
               </div>

               <div style="display: flex; justify-content: space-between; align-items: center;">
                  <div id="error-message" style="color: red; margin-top: 15px;">
                     <p><?= $error_message ?></p>
                  </div>
                  <div><a href="#" class="login__forgot" onclick="modalShow('forgotPasswordModal')">Forgot your password?</a></div>
               </div>
               <button type="submit" name="login" class="login__button">Login</button>
            </form>
         </div>
      </div>
   </div>


 <!-- forgot-password -->
<div id="forgotPasswordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="modalHide('forgotPasswordModal')">❌</span>
        <h2>Forgot Your Password?</h2>
        <p>Enter your username to search for your account, and then answer the question correctly.</p>
        <div style="padding: 14px 8px 8px 8px; text-align: left">
            <p>Username <span style="color: c21807; font-weight: 600">*</span></p>
            <input type="text" id="fpass-username" placeholder="Enter Username" required class="modal__input" autocomplete="off" required>
            <p id="fpass-username-error" class="text-danger" style="color:red"></p>
        </div>

        <div class="modal-footer">
            <button style="background-color: #0F52BA; color: #f9f9f9; border: none" id="fpass-submit-username">Submit</button>
            <button onclick="modalHide('forgotPasswordModal')">Cancel</button>
        </div>
    </div>
</div>
<!-- forgot-password -->

<!-- security-question -->
<div id="securityQuestionModal" class="modal">
   <div class="modal-content">
      <span class="close" onclick="modalShow('forgotPasswordModal')">❌</span>
      <h2>Security Question</h2>
      <div style="padding: 14px 8px 8px 8px; text-align: left">
         <p id="fpass-question1">Set a question <span style="color: c21807; font-weight: 600">*</span></p>
         <input type="text" id="fpass-answer1" placeholder="Answer" required class="modal__input" autocomplete="off">
         <span id="fpass-answer1-error" style="color: red;"></span>
         <div id="cooldown"></div>

         <div id="attemptMsg"></div>
      </div>

      <div class="modal-footer">
         <button id="answer-check-submit" style="background-color: #0F52BA; color: #f9f9f9; border: none">Submit</button>
         <button onclick="modalShow('forgotPasswordModal')">Back</button>
      </div>
   </div>
</div>
<!-- security-question -->

<!-- Create new Password-->
<form action="" method="post">
<input type="hidden" name="username" id="newPass_username">
   <div id="create_new_password" class="modal">
      <div class="modal-content">
         <span class="close" onclick="modalShow('newPasswordModal')">❌</span>
         <h2>Enter New Password</h2>
         <div style="padding: 14px 8px 8px 8px; text-align: left">
            <p id="fpass-newpass">New Password <span style="color: c21807; font-weight: 600">*</span></p>
            <input type="password" id="fpass-newpass-input" name="new_password" placeholder="Answer" required class="modal__input" autocomplete="off">
         </div>
         <div style="padding: 14px 8px 8px 8px; text-align: left">
            <p id="fpass-Confirmpass">Confirm Password <span style="color: c21807; font-weight: 600">*</span></p>
            <input type="password" id="fpass-Confirmpass-input" name="confirm_password" placeholder="Answer" required class="modal__input" autocomplete="off">
            <span id="fpass-cpass-error" style="color: red;"></span>
         </div>

         <div class="modal-footer">
            <button type="submit" name="type" value="update-password" id="create_password_submit" style="background-color: #0F52BA; color: #f9f9f9; border: none">Submit</button>
            <button onclick="modalShow('securityQuestionModal')">Back</button>
         </div>
      </div>
   </div>
</form>

<!-- Create new Password -->

<div id="scriptDiv"></div>

<?= include("./includes/alert_msg.php"); ?>
   <script>

function getMinutesAndSeconds(date1, date2) {
    // Get the time difference in milliseconds
    const timeDiff = Math.abs(date2.getTime() - date1.getTime());

    // Convert milliseconds to minutes and seconds
    const minutes = Math.floor(timeDiff / 60000); // 1 minute = 60,000 milliseconds
    const seconds = Math.floor((timeDiff % 60000) / 1000); // 1 second = 1,000 milliseconds

    return { minutes, seconds };
  }

  function enableAttempt(user){
    clearInterval(window.timeInterval);
    $("#fpass-answer-error").html("");

    $("#fpass-answer1").val("");
    $("#fpass-answer1").attr("disabled", false);
    $("#fpass-submit-answer").attr("disabled", false);
    $("#attemptMsg").html("");

    $.post("./ajax/forgetPassword.php", {
            type: "enableAttempt",
            username: user
        },
        function(data){
            //
        });
  }

      
      const passwordAccess = (loginPass, loginEye) => {
         const input = document.getElementById(loginPass),
            iconEye = document.getElementById(loginEye);

         iconEye.addEventListener('click', () => {
            // Toggle password visibility
            input.type = input.type === 'password' ? 'text' : 'password';

            // Toggle the eye icon class
            iconEye.classList.toggle('uil-eye');
            iconEye.classList.toggle('uil-eye-slash');
         });
      };
      passwordAccess('password', 'loginPassword');

      
  function disableAttempt(user, nextAttempt){
    $("#fpass-answer1").attr("disabled", true);
    $("#fpass-submit-answer").attr("disabled", true);


    window.timeInterval = setInterval(function () {
        // Example usage
        const date1 = new Date();
        const date2 = new Date(nextAttempt);
        const { minutes, seconds } = getMinutesAndSeconds(date1, date2);

        $("#attemptMsg").html(`You have entered wrong answer too many times <br> Try again in ` + (minutes > 10 ? minutes + `:` : '') + `${seconds}`);

        if(minutes <= 0 && seconds <= 0){
            enableAttempt(user);
            clearInterval(window.timeInterval);
        }
    }, 1000);

  
  }

 //check if username exists
$("#fpass-submit-username").click(function(){
    var user = $("#fpass-username").val();
    $.post(
      "./ajax/forgetPassword.php",
      {
        type: "username-check",
        username: user
      },
      function(data) {
        $("#scriptDiv").html(data);
      }
    );
});

//check if answers are correct
$("#answer-check-submit").click(function(){
    var user = $("#fpass-username").val();
    var a1 = $("#fpass-answer1").val();
    $.ajax({
      type: "post",
      url: "./ajax/forgetPassword.php",
      data: {
        type: "answer-check",
        username: user,
        answer1: a1
      },
      success: function(data) {
        $("#scriptDiv").html(data);
      },
      error: function(err){
         console.log(err)
      }

    });
  });

    //check if answers are correct
    $("#create_password_submit").click(function(){
    var user = $("#fpass-username").val();
    var pass = $("#fpass-newpass-input").val();
    var cpass = $("#fpass-Confirmpass-input").val();
    $.post(
      "./ajax/forgetPassword.php",
      {
        type: "update-password",
        username: user,
        new_password: pass,
        confirm_password: cpass
      },
      function(data) {
        $("#scriptDiv").html(data);
      }
    );
  });



   </script>
   <script>
// Show the modal and close the previously opened modal
function modalShow(modalId) {
   // Close any currently open modal
   const openModals = document.querySelectorAll('.modal');
   openModals.forEach(modal => {
      modal.style.display = 'none';
   });

   // Show the new modal
   const modal = document.getElementById(modalId);
   if (modal) {
      modal.style.display = 'block';
   } else {
      console.error(`Modal with ID "${modalId}" not found.`);
   }
}

// Hide the modal
function modalHide(modalId) {
   const modal = document.getElementById(modalId);
   if (modal) {
      modal.style.display = 'none';
   }
}



</script>

</body>

</html>