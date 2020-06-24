<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = delete_work($_POST['i']);
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
