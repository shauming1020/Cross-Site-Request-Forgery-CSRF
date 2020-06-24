<?php
  require_once '../php/connectDB.php';
  if(isset($_SESSION['is_login']) && $_SESSION['is_login'] == true)
  {
    header('Location: index.php');
  }
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
    <link rel="shortcut icon" href="../images/camera.ico">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h1 class="text-center">會員登入</h1>
            <form method="post" action="../php/add_user.php" id="loginForm">
              <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label" id="usernameLabel">帳號</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label" id="passwordLabel">密碼</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">登入</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include_once 'footer.php'; ?>
      <!-- 載入 jquery -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script type="text/javascript">
      <!-- 當文件準備好，要做的事情是 -->
        $(document).ready(function()
        {
          // 因為form id是唯一的, 所以可以將 form#registerForm 省略成 #registerForm
          $("#loginForm").submit(function(){
            // 先擋下來用 ajHX 去送給 add_user.php
            $.ajax({// 要傳送的包裹
              type : "post",// 在後端用表單送出去
              url : "../php/verify_user.php",// 要送給誰處理
              data :
              {
                'un' : $("#username").val(),// 傳送一個變數 un(代表name), 把 $(this).val() 的值丟進去
                'pw' : $("#password").val()
              },
              dataType : 'html' // check_username.php處理完後應該回傳html式
            }).done(function(data)
            {// 有正常接收訊息, 回傳的訊息叫作 data
              if(data == 'yes')
              {
                // 登入成功
                console.log(data);
                window.location.href = "index.php";
              }else
              {
                alert("登入失敗，請檢查帳號密碼。");
              }
            }).fail(function(jqXHR, textStatus, errorThrown){
              // 失敗的時候
              alert("有錯誤產生，請查看console log");
              console.log(jqXHR.responseText);
            });

          return false; // 擋下來

          });
        });
    </script>
  </body>
</html>
