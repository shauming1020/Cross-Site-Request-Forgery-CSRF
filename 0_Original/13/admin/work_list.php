<?php
  require_once '../php/connectDB.php';
  require_once '../php/functions.php';
  if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == false)
  {
    header('Location: login.php');
  }
  $works = get_all_work();


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>AnDj 官方網站-後台-作品列表</title>
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
            <a href="work_add.php" class="btn btn-primary">新增作品</a>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm">
            <table class="table table-hover table-dark">
              <thead>
                <tr>
                  <th scope="col">簡介</th>
                  <th scope="col">圖片路徑</th>
                  <th scope="col">影片路徑</th>
                  <th scope="col">發佈狀態</th>
                  <th scope="col">上傳時間</th>
                  <th scope="col">管理動作</th>

                </tr>
              </thead>
              <tbody>
                <?php if(!empty($works)): ?>
                  <?php foreach ($works as $work): ?>
                    <tr>
                      <th scope="row"><?php echo "{$work['intro']}"; ?></th>
                      <td><?php echo "{$work['image_path']}"; ?></td>
                      <td><?php echo "{$work['video_path']}"; ?></td>
                      <td><?php echo ($work['publish'])?"發佈中":"隱藏中"; ?></td>
                      <td><?php echo "{$work['upload_date']}"; ?></td>
                      <td>
                        <a href="work_edit.php?id=<?php echo "{$work['id']}"; ?>" class="btn btn-success">編輯</a>
                        <a href="javascript:void(0);" class="btn btn-danger del_work" data-id="<?php echo "{$work['id']}"; ?>">刪除</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">無資料</td>
                  </tr>
                <?php endif; ?>

              </tbody>
            </table>
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
        $("a.del_work").click(function(){
          var c = confirm("你確定要刪除嗎?");
          var this_tr = $(this).parent().parent(); // 找到要刪除的東西

          if(c)
          {
            $.ajax({// 要傳送的包裹
              type : "post",// 在後端用表單送出去
              url : "../php/delete_work.php",// 要送給誰處理
              data :
              {
                'i' : $(this).attr("data-id")
              },
              dataType : 'html' // check_username.php處理完後應該回傳html式
            }).done(function(data)
            {// 有正常接收訊息, 回傳的訊息叫作 data
              if(data == 'yes')
              {
                // 登入成功
                console.log(data);
                this_tr.fadeOut();
                alert("刪除成功，點擊確認移除資料。");

              }else
              {
                console.log(data);
                alert("刪除失敗，請檢查網路連線。");
              }
            }).fail(function(jqXHR, textStatus, errorThrown){
              // 失敗的時候
              alert("有錯誤產生，請查看console log");
              console.log(jqXHR.responseText);
            });
          }
        });

        // 因為 javascript.void(0) 就會擋掉，所以不用再寫 return false;
      });
  </script>
  </body>
</html>
