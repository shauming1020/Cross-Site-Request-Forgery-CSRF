<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = update_member($_POST['i'], $_POST['n'], $_POST['un'], $_POST['pw']);
  if($check)
  {
    // 帳號存在
    echo "yes";
  }else
  {
    // 帳號不存在
    echo "no";
  }
?>
