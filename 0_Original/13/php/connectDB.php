<?php
  // @ 避免同時使用時衝撞
  @session_start();
  // 資料庫主機的 ip 或資料庫主機的網域名稱
  // 如果主機與資料庫在同一台電腦上，就可以用 localhost
  $host = 'localhost';
  // 資料庫的登入帳號
  $db_user = 'root';
  // 資料庫的登入密碼
  $db_password = '';
  // 資料庫名稱
  $db_name = 'works_website_db';
  // 宣告一個 link 變數並執行 mysqli_connect(), 連結結果會帶入 link 當中
  // 如果 link = true 代表連線成功
  $_SESSION['link'] = mysqli_connect($host, $db_user, $db_password, $db_name);

  // 如果建立連結成功, $link 的值非 0
  if($_SESSION['link'])
  {
    //mysqli_query(資料庫連線, "sql語法");
    mysqli_query($_SESSION['link'], "SET NAMES utf8");
    //echo "已正確連線";
  }else
  {
    echo "無法連線至mySQL資料庫 :<br />".mysqli_connect_error();
  }
 ?>
