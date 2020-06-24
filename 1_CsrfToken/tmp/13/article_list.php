<?php
  require_once 'php/connectDB.php';
  require_once 'php/functions.php';
  $articles = get_publish_article();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>AnDj 官方網站</title>
    <meta name="description" content="AnDj官方網站, 藝術創作!">
    <meta name="author" content="Liang">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 使用 bootstrap 的排版格式 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <link rel="shortcut icon" href="images/camera.ico">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <?php include_once 'menu.php'; ?>
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <?php if(!empty($articles)): ?>
              <?php foreach ($articles as $article):
                //處理摘要
                // strip_tags() 清除 html 元素
                $abstract = strip_tags($article['content']);
                // 利用 mb_substr() 抓取 100 字
                $abstract = mb_substr($abstract, 0, 100, "UTF-8");
              ?>
              <div class="card bg-dark mb-3">
                <div class="card-header text-white">Header</div>
                <a href="article.php?id=<?php echo "{$article['id']}"; ?>">
                  <div class="card-body bg-white">
                    <h5 class="card-title"><?php echo "{$article['title']}"; ?></h5>
                    <p>
                      <span class="badge badge-dark"><?php echo "{$article['category']}"; ?></span>
                      <span class="badge badge-light"><?php echo "{$article['create_date']}"; ?></span>
                    </p>
                    <p class="card-text"><?php echo "{$abstract}"." ... MORE"; ?></p>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php include_once 'footer.php'; ?>
  </body>
</html>
