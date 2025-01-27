<?php
if (! isset($_SESSION['username']) and ! isset($_SESSION['user_role'])) {
  header("Location: http://localhost/JackSizzling/login-page.php");
  exit();
}
?>
