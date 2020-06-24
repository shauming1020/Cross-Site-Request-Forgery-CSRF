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
            <form method="post" action="php/add_user.php" id="registerForm">
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">名稱</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
              </div>
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
                <label for="confirmPassword" class="col-sm-2 col-form-label" id="confirmPasswordLabel">再次確認密碼</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="confirmPassword" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">註冊</button>
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
          // 當帳號輸入後檢查帳號是否重複
          $("#username").keyup(function()
          {
            if($(this).val() != '')
            {
              // 非空字串, 檢查帳號
              $.ajax({// 要傳送的包裹
                type : "post",// 在後端用表單送出去
                url : "php/check_username.php",// 要送給誰處理
                data :
                {
                  'n' : $(this).val()// 傳送一個變數 n(代表name), 把 $(this).val() 的值丟進去
                },
                dataType : 'html' // check_username.php處理完後應該回傳html式
              }).done(function(data)
              {// 有正常接收訊息, 回傳的訊息叫作 data
                if(data == 'yes')
                {
                  // 把文字方塊變紅色, 按鈕不可按
                  alert("帳號已存在，請更換帳號名稱。");
                  $("#usernameLabel").removeClass("text-success").addClass("text-danger");
                  $("#username").removeClass("form-control valid").addClass("form-control is-invalid");
                  // 找到registerForm 底下的 button
                  $("#registerForm button[type='submit']").attr('disabled', true);
                }else
                {
                  // 帳號不存在可以註冊
                  // 把文字方塊變紅色, 按鈕不可按
                  $("#usernameLabel").removeClass("text-danger").addClass("text-success");
                  $("#username").removeClass("form-control is-invalid").addClass("form-control valid");
                  $("#registerForm button[type='submit']").attr('disabled', false);
                }
              }).fail(function(jqXHR, textStatus, errorThrown){
                // 失敗的時候
                alert("有錯誤產生，請查看console");
                console.log(jqXHR.responseText);
              });

            }else {
              //空字串, 不檢查帳號
              $("#usernameLabel").removeClass("text-success").removeClass("text-danger");
              $("#username").removeClass("valid").removeClass("is-invalid");
              $("#registerForm button[type='submit']").attr('disabled', false);
            }

          });




          // 因為form id是唯一的, 所以可以將 form#registerForm 省略成 #registerForm
          $("#registerForm").submit(function(){
            if($("#password").val() != $("#confirmPassword").val()){
              $("#passwordLabel").addClass("text-danger");
              $("#password").addClass("form-control is-invalid");
              $("#confirmPasswordLabel").addClass("text-danger");
              $("#confirmPassword").addClass("form-control is-invalid");
              alert("密碼有誤, 請重新輸入。");

            }else {
              // 密碼正確, 先擋下來用 ajHX 去送給 add_user.php
              $.ajax({// 要傳送的包裹
                type : "post",// 在後端用表單送出去
                url : "php/add_user.php",// 要送給誰處理
                data :
                {
                  'n' : $("#name").val(), // 在這邊取 'n' 的原因是怕會被猜出來
                  'un' : $("#username").val(),// 傳送一個變數 un(代表name), 把 $(this).val() 的值丟進去
                  'pw' : $("#password").val()
                },
                dataType : 'html' // check_username.php處理完後應該回傳html式
              }).done(function(data)
              {// 有正常接收訊息, 回傳的訊息叫作 data
                console.log(data);
                if(data == 'yes')
                {
                  alert("註冊成功，請按確認轉跳登入頁。");
                  window.location.href = "admin/index.php";
                }else
                {
                  alert("註冊失敗，請檢查網路連線狀態，若仍無法解決，請聯繫系統工程人員。");
                }
              }).fail(function(jqXHR, textStatus, errorThrown){
                // 失敗的時候
                alert("有錯誤產生，請查看console log");
                console.log(jqXHR.responseText);
              });
            }
            return false; // 擋下來

          });
        });
    </script>
  </body>
</html>
