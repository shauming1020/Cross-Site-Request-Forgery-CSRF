<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = check_has_username($_POST['n']);
  if($check)
  {
    // 帳號存在
    echo "yes";
  }else {
    // 帳號不存在
    echo "no";
  }
?>
