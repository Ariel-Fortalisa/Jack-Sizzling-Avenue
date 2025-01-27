<?php
session_start();

$enteredOldPassword = $_POST['old_password'];

$storedHashedPassword = $_SESSION["password"];

if (password_verify($enteredOldPassword, $storedHashedPassword)) {
    echo 'valid';
} else {
    echo 'invalid';
}
?>