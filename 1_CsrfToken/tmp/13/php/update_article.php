<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = update_article($_POST['i'], $_POST['t'], $_POST['ca'], $_POST['co'], $_POST['p']);
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
