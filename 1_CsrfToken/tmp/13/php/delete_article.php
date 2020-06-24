<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = False;
  if (isset($_SESSION['token'])){
	  /*
	echo $_POST['i'];
	echo $_SESSION['token'];
	echo $_POST['mycsrftoken'];
	*/
	//if (strcmp($_POST['mycsrftoken'], $_SESSION['token']) == 0) {
	if ($_POST['mycsrftoken'] == $_SESSION['token']) {
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
