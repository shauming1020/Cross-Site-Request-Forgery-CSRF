<?php
  require_once 'php/connectDB.php';
  require_once 'php/functions.php';
  $works = get_publish_work();
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

            <?php if(!empty($works)): ?>
            <?php foreach ($works as $work):?>

              <div class="col-sm-4">
              <div class="card" style="width: 18rem;">
                <?php if($work['image_path']): ?>
                  <img src="<?php echo "{$work['image_path']}"; ?>" alt="Responsive image" class="img-fluid rounded mx-auto d-block img-thumbnail">
                <?php else: ?>
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="<?php echo "{$work['video_path']}"; ?>" allowfullscreen>
                    </iframe>
                  </div>
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text"><?php echo "{$work['intro']}"; ?></p>
                  <a href="work.php?id=<?php echo "{$work['id']}"; ?>" class="btn btn-primary">放大</a>
                </div>
              </div>
              </div>
            <?php endforeach; ?>
            <?php else: ?>
              <h1>沒有作品</h1>
            <?php endif; ?>

        </div>
      </div>
    </div>
    <?php include_once 'footer.php'; ?>
  </body>
</html>
