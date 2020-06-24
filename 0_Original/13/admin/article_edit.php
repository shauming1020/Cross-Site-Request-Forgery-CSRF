<?php
  require_once '../php/connectDB.php';
  require_once '../php/functions.php';
  if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == false)
  {
    header('Location: login.php');
  }
  $article = get_edit_article($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>AnDj 官方網站-後台-編輯文章</title>
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
            <form id="articleForm">
              <input type="hidden" id="articleId" value="<?php echo "{$article['id']}"; ?>">
              <div class="form-group">
                <label for="titleInput">標題</label>
                <input type="text" class="form-control" id="titleInput" value="<?php echo "{$article['title']}"; ?>">
              </div>
              <div class="form-group">
                <label for="categorySelect">分類</label>
                <select class="form-control" id="categorySelect">
                  <option <?php echo ($article['category'] == "微小說")?"selected":""; ?>>微小說</option>
                  <option <?php echo ($article['category'] == "小說")?"selected":""; ?>>小說</option>
                  <option <?php echo ($article['category'] == "歌詞")?"selected":""; ?>>歌詞</option>
                  <option <?php echo ($article['category'] == "心情手札")?"selected":""; ?>>心情手札</option>
                  <option <?php echo ($article['category'] == "生活記錄")?"selected":""; ?>>生活記錄</option>
                  <option <?php echo ($article['category'] == "勵志小語")?"selected":""; ?>>勵志小語</option>
                </select>
              </div>
              <div class="form-group">
                <label for="contentArea">內文</label>
                <textarea class="form-control" id="contentArea" rows="20"><?php echo "{$article['content']}"; ?></textarea>
              </div>
              <div>
                <label>發佈狀態</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="publish" id="inlineRadio1" value="1" <?php echo ($article['publish'] == 1)?"checked":""; ?>>
                <label class="form-check-label" for="inlineRadio1">公開</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="publish" id="inlineRadio2" value="0" <?php echo ($article['publish'] == 0)?"checked":""; ?>>
                <label class="form-check-label" for="inlineRadio2">私人</label>
              </div>
              <div class="submitBtn">
                <br/>
                <button type="submit" class="btn btn-primary">儲存</button>
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
        $("#articleForm").submit(function(){
          if($("#titleInput").val() == '')
          {
            alert("請填寫標題。");
          }else if($("#contentArea").val() == '')
          {
            alert("請填寫內文。");
          }else{
            // 先擋下來用 ajHX 去送給 add_user.php
            $.ajax({// 要傳送的包裹
              type : "post",// 在後端用表單送出去
              url : "../php/update_article.php",// 要送給誰處理
              data :
              {
                'i' : $("#articleId").val(),
                't' : $("#titleInput").val(),// 傳送一個變數 un(代表name), 把 $(this).val() 的值丟進去
                'ca' : $("#categorySelect").val(),
                'co' : $("#contentArea").val(),
                'p' : $("input[name='publish']:checked").val()//input 那個區塊中 name=publish 的, 被選到的那個
              },
              dataType : 'html' // check_username.php處理完後應該回傳html式
            }).done(function(data)
            {// 有正常接收訊息, 回傳的訊息叫作 data
              if(data == 'yes')
              {
                // 登入成功
                console.log(data);
                alert("更新成功，點擊確認回到列表頁。");
                window.location.href = "article_list.php";
              }else
              {
                console.log(data);
                alert("更新失敗，請檢查網路連線。");
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
