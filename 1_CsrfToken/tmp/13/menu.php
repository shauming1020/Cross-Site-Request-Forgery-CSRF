<?php
  // 取得目前檔案的名稱
  // $_SERVER 儲存網域名稱等，這裡用 $_SERVER['PHP_SELF'] 先取得檔案路徑
  // ex /01phpTutorial/13/about.php
  $filePath = $_SERVER['PHP_SELF'];
  // 取得路徑的檔名並過濾掉檔案格式.php，ex article
  $fileName = basename($filePath, ".php");
  switch ($fileName) {
    case 'article_list':
      $pageIndex = 1;
      break;
    case 'article':
      $pageIndex = 1;
      break;
    case 'work_list':
      $pageIndex = 2;
      break;
    case 'work':
      $pageIndex = 2;
      break;
    case 'about':
      $pageIndex = 3;
      break;
    case 'register':
      $pageIndex = 4;
      break;
    default:
      // 預設是首頁，用 0 代表
      $pageIndex = 0;
      break;
  }
?>
<div class="top">
  <div class="jumbotron">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <h1 class="text-center">AnDj</h1>
          <nav class="nav nav-pills nav-fill">
            <a class="nav-item nav-link <?php if($pageIndex == 0){echo 'active';} ?>" href="./" >首頁</a>
            <a class="nav-item nav-link <?php if($pageIndex == 1){echo 'active';} ?>" href="article_list.php">所有文章</a>
            <a class="nav-item nav-link <?php if($pageIndex == 2){echo 'active';} ?>" href="work_list.php">所有作品</a>
            <a class="nav-item nav-link <?php if($pageIndex == 3){echo 'active';} ?>" href="about.php">關於我們</a>
            <a class="nav-item nav-link <?php if($pageIndex == 4){echo 'active';} ?>" href="register.php">註冊</a>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
