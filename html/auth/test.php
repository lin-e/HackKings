<?php
  include("../assets/includes/config.php");
  include("../assets/includes/composer/vendor/autoload.php");
  session_start();
  echo $_SESSION['sid'];
  $token = $db->real_escape_string($_SESSION['sid']);
  $q = $db->query("SELECT * FROM sessions WHERE sid='$token' AND status=1");
  return mysqli_num_rows($q) > 0;
?>