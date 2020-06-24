<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = False;
  if (isset($_COOKIE['token']) and isset($_SESSION['token'])){
	  $a = $_POST['mycsrftoken'];
	  $a = md5($a*1234);
	if ($a == $_COOKIE['token'] and $a == $_SESSION['token']) {
		$match = True;
		$check = delete_article($_POST['i']);
	}else {
		$match = False;
	}
	
	// 收到的token應要與伺服器所設定的一致
    if($check && $match) 
    {
	  // 帳號存在
	echo "yes";
    }else
    {
	  // 帳號不存在
	echo "no";
    }
	
  }else {
	echo "no";
  }
	 
?>
