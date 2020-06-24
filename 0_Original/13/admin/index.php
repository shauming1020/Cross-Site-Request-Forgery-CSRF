<?php
  require_once '../php/connectDB.php';
  if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == false)
  {
    header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>AnDj 官方網站-後台</title>
    <meta name="description" content="AnDj官方網站, 藝術創作!">
    <meta name="author" content="Liang">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 使用 bootstrap 的排版格式 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <link rel="shortcut icon" href="../images/camera.ico">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <?php include_once 'menu.php'; ?>
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <div class="alert alert-primary" role="alert">
              <p class="text-center">歡迎來到 AnDj 官方網站。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_once 'footer.php'; ?>
  </body>
</html>
