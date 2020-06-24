<?php
  require_once '../php/connectDB.php';
  require_once '../php/functions.php';
  if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == false)
  {
    header('Location: login.php');
  }
  $articles = get_all_article();
  
  // 伺服器端在SESSION中設定一組隨機生成的Token
  $answer = md5(mktime() * 1234);
  $_SESSION['token'] = $answer; // 只有SERVER自己知道這個值，並定期更新

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>AnDj 官方網站-後台-文章列表</title>
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
            <a href="article_add.php" class="btn btn-primary">新增作品</a>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm">
            <table class="table table-hover table-dark">
              <thead>
                <tr>
                  <th scope="col">標題</th>
                  <th scope="col">分類</th>
                  <th scope="col">發佈狀態</th>
                  <th scope="col">建立時間</th>
                  <th scope="col">管理動作</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($articles)): ?>
                  <?php foreach ($articles as $article): ?>
                    <tr>
                      <th scope="row"><?php echo "{$article['title']}"; ?></th>
                      <td><?php echo "{$article['category']}"; ?></td>
                      <td><?php echo ($article['publish'])?"發佈中":"隱藏中"; ?></td>
                      <td><?php echo "{$article['create_date']}"; ?></td>
                      <td>
                        <a href="article_edit.php?id=<?php echo "{$article['id']}"; ?>" class="btn btn-success">編輯</a>
                        <a href="javascript:void(0);" 
						class="btn btn-danger del_article" 
						data-id="<?php echo "{$article['id']}"; ?>" 
						csrf-token="<?php echo $answer; ?>">刪除</a>
						<!-- 傳送一組與SESSION中相同的Token給刪除功能 -->
						
						</td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">無資料</td>
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
        $("a.del_article").click(function(){
          var c = confirm("你確定要刪除嗎?");
          var this_tr = $(this).parent().parent(); // 找到要刪除的東西

          if(c)
          {
            $.ajax({// 要傳送的包裹
              type : "post",// 在後端用表單送出去
              url : "../php/delete_article.php",// 要送給誰處理
              data :
              {
                'i' : $(this).attr("data-id"),
                'mycsrftoken' : $(this).attr("csrf-token") // 傳送正確的token
              },
              dataType : 'html', // check_username.php處理完後應該回傳html式
            }).done(function(data)
            {// 有正常接收訊息, 回傳的訊息叫作 data
              if(data == 'yes')
              {
                // 登入成功

                this_tr.fadeOut();
                alert("刪除成功，點擊確認移除資料。");

              }else
              {
				alert(data);
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
