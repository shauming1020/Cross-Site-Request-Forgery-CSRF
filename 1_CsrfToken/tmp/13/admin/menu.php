<?php
  // 取得目前檔案的名稱
  // $_SERVER 儲存網域名稱等，這裡用 $_SERVER['PHP_SELF'] 先取得檔案路徑
  // ex /01phpTutorial/13/about.php
  $filePath = $_SERVER['PHP_SELF'];
  // 取得路徑的檔名並過濾掉檔案格式.php，ex article
  $fileName = basename($filePath, ".php");
  switch ($fileName) {
    case 'article_list':
    case 'article_edit':
    case 'article_add':
      $pageIndex = 1;
      break;
    case 'work_list':
    case 'work_edit':
    case 'work_add':
      $pageIndex = 2;
      break;
    case 'member_list':
    case 'member_edit':
    case 'member_add':
      $pageIndex = 3;
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
            <a class="nav-item nav-link" href="../index.php" >前台首頁</a>
            <a class="nav-item nav-link <?php if($pageIndex == 0){echo 'active';} ?>" href="./" >後台首頁</a>
            <a class="nav-item nav-link <?php if($pageIndex == 1){echo 'active';} ?>" href="article_list.php">所有文章</a>
            <a class="nav-item nav-link <?php if($pageIndex == 2){echo 'active';} ?>" href="work_list.php">所有作品</a>
            <a class="nav-item nav-link <?php if($pageIndex == 3){echo 'active';} ?>" href="member_list.php">所有會員</a>
            <a class="nav-item nav-link" href="../php/logout.php">登出</a>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
