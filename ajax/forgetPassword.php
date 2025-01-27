<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("../includes/connection.php");

$type = $_POST["type"];
// $type = "answer-check";


if ($type === "username-check") {
    
    $user = $_POST["username"];
    // $user = "admin";

    $usernameExist = $conn->query("SELECT * FROM users WHERE username = '$user'");
  
    if ($usernameExist->num_rows > 0) {
        // User exists
        $row = $usernameExist->fetch_assoc();

        // Get security question and other details
        $qId1 = $row['security_question1'];
        $question1 = $conn->query("SELECT list_question FROM security_question WHERE id = $qId1")->fetch_assoc()["list_question"];

        $loginAttempt = $row['login_attempt'];

        // Check login attempts and whether the user is allowed to try again
        if ($loginAttempt >= 3) {
            $nextAttempt = date("Y-m-d H:i:s", strtotime($row['next_attempt']));
            if ($nextAttempt <= date("Y-m-d H:i:s")) {
                // Reset login attempts if allowed
                $conn->query("UPDATE users SET login_attempt = 0, next_attempt = NULL WHERE username = '$user'");
                $loginAttempt = 0;
            }
        }else{
            $conn->query("UPDATE users SET login_attempt = login_attempt + 1 WHERE username = '$user'");
        }

        echo '
        <script>
            clearInterval(window.timeInterval);
            '.(
                $loginAttempt >= 3 ? 'disableAttempt("'.$user.'", "'.$nextAttempt.'");' : 'enableAttempt("'.$user.'");'
            ).'
            
            // Display the question and reset any previous error message
            $("#fpass-question1").html("'.$question1.'");
            $("#fpass-username-error").html("");
            modalHide("forgotPasswordModal");
            modalShow("securityQuestionModal");

        </script>';
    } else {
        // Username not found
        echo '
        <script>
            $("#fpass-username-error").html("No username found");
        </script>';
    }
}
elseif($type === "enableAttempt"){
    $username = $_POST["username"];
    $conn->query("UPDATE users SET login_attempt = 0, next_attempt = NULL WHERE username = '$username'");

}elseif($type === "answer-check"){
        $user = $_POST["username"];
        // $user = "admin";
        $a1 = $_POST["answer1"];
        // $a1 = "pitchie";

        $answer1 = $conn->query("SELECT answer_1 FROM users WHERE username = '$user'")->fetch_assoc()["answer_1"];
    
        $a1Correct = false;

        //check if answer 1 is correct
        if($a1 === $answer1){
            $a1Correct = true;
        }else{
            $a1Correct = false;
        }

        if($a1Correct == true){
            echo '
                <script>
                    $("#fpass-answer1-error").html("");
                    modalHide("securityQuestionModal");
                    $("#newPass_username").val("'.$user.'")
                    modalShow("create_new_password");
                </script>
            ';
        }else{       
            echo '
                <script>
                    $("#fpass-answer1-error").html("Incorrect Answer");
                </script>
            ';
            $loginAttempt = $conn->query("SELECT login_attempt FROM users WHERE username = '$user'")->fetch_assoc()["login_attempt"];

            if($loginAttempt >= 3){
                $conn->query("UPDATE users SET next_attempt = '".date("Y-m-d H:i:s", strtotime("+60 minutes"))."' WHERE username = '$user'");

                $nextAttempt = date("Y-m-d H:i:s", strtotime($conn->query("SELECT next_attempt FROM users WHERE username = '$user'")->fetch_assoc()["next_attempt"]));

                echo '
                    <script>
                        disableAttempt("'.$user.'", "'.$nextAttempt.'");
                    </script>
                ';
                
            }
            else{
                $conn->query("UPDATE users SET login_attempt = login_attempt + 1 WHERE username = '$user'");
            }
        }
        

} elseif($type === "update-password"){
    $user = $_POST["username"];
    $newpass = $_POST["new_password"];
    $cpass = $_POST["confirm_password"];

    if($newpass === $cpass){

        $hashedPass = password_hash($newpass, PASSWORD_DEFAULT);
        $conn->query("
            UPDATE users
            SET password = '$hashedPass'
            WHERE username = '$user'
        ");
        echo '
            <script>
                $("#fpass-cpass-error").html("");
                modalHide("create_new_password");
                
            </script>
        ';
    }
    else{
        echo '
            <script>
                $("#fpass-cpass-error").html("Password does not match");
            </script>
        ';
        
    }

    $_SESSION["success_message"] = "Your password has been changed successfully";
    header('Location: ../login-page');
    exit();
}
elseif($type === "enableAttempt"){
    $username = $_POST["username"];
    $conn->query("UPDATE users SET login_attempt = 0, next_attempt = NULL WHERE username = '$username'");
}
?>