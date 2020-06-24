<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = add_work($_POST['i'], $_POST['ip'], $_POST['vp'], $_POST['p']);
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
