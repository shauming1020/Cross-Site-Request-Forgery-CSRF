<?php
  require_once '../php/connectDB.php';
  require_once '../php/functions.php';
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
    <title>AnDj 官方網站-後台-新增作品</title>
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
            <form id="workForm">
              <div class="form-group">
                <label for="introArea">簡介</label>
                <textarea class="form-control" id="introArea" rows="5"></textarea>
              </div>
              <div class="form-group">
                <label for="imageInput">圖片上傳</label>
                <br />
                <input type="hidden" id="imagePath" value="">
                <input type="file" class="image" id="imageInput" accept="image/*">
                <div class="showImage" style="padding-top: 20px;">
                </div>
                <div class="delImage" style="padding-top: 20px;">
                  <a href="javascript:void(0);" class="deleteImage btn btn-primary">刪除</a>
                </div>
              </div>
              <div class="form-group">
                <label for="videoInput">影片上傳</label>
                <br />
                <input type="hidden" id="videoPath" value="">
                <input type="file" class="video" id="videoInput" accept="video/*">
                <div class="showVideo embed-responsive embed-responsive-16by9" style="padding-top: 20px;">

                </div>
                <div class="delVideo" style="padding-top: 20px;">
                  <a href="javascript:void(0);" class="deleteVideo btn btn-primary">刪除</a>
                </div>
              </div>
              <div>
                <label>發佈狀態</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="publish" id="inlineRadio1" value="1" checked>
                <label class="form-check-label" for="inlineRadio1">公開</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="publish" id="inlineRadio2" value="0">
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
        // 圖片選擇後自動上傳
        $("input.image").change(function()
        {
          //console.log($(this));// 取得圖片物件詳細資料
          //console.log($(this)[0].files[0]);// 取得圖片物件目標資料
          var file = $(this)[0].files[0];
          var save_path = "files/images/";
          var form_data = new FormData();
          form_data.append("file", file); // append(key, value)
          form_data.append("save_path", save_path);
          $.ajax({
            type : 'POST',
            url : '../php/upload_file.php',
            data : form_data, // 上面的那個
            cache : false, // 因為只有上傳檔案, 所以不要暫存
            processData : false, // 因為只有上傳檔案, 不須處理表單資訊
            contentType : false, // 送過去的內容由 FormData 產生(決定格式為多型態)
            dataType : 'html'
          }).done(function(data){
            if(data == 'yes')// 顯示圖片
            {
              // 在這個 div 中引入 img
              $("div.showImage").html("<img src='../" + save_path + file['name'] + "' style='height: 300px;'>");
              // 把相對路徑存到 input hidden 中, 之後送出表單才可以抓到
              $("#imagePath").val(save_path + file['name']);

            }else
            {

            }
            //console.log(data);
          }).fail(function(jqXHR, textStatus, errorThrown){
            // 失敗的時候
            alert("有錯誤產生，請查看console log");
            console.log(jqXHR.responseText);
          });
        });
        // 圖片刪除事件(傳錯檔案)
        $("a.deleteImage").click(function()
        {
          if($("#imagePath").val() != '')// 有圖片
          {
            var c = confirm("你確定要刪除嗎?此動作無法回復。");
            if(c)
            {
              $.ajax({
                type : 'POST',
                url : '../php/delete_file.php',
                data : {
                  'f' : $("#imagePath").val()
                },
                dataType : 'html'
              }).done(function(data){
                if(data == 'yes')// 清除圖片
                {

                  // 在這個 div 中引入 img
                  $("div.showImage").html("");
                  // 清除相對路徑
                  $("#imagePath").val();
                  // 已選擇的 input 也要清掉
                  $("#imageInput").val('');
                  //console.log(data);
                }else {
                  //console.log(data);
                }
              }).fail(function(jqXHR, textStatus, errorThrown){
                // 失敗的時候
                alert("有錯誤產生，請查看console log");
                console.log(jqXHR.responseText);
              });
            }
          }else // 無圖片
          {
            alert("尚未上傳檔案，無法刪除。");
          }
        });
        // 影片選擇後自動上傳
        $("input.video").change(function()
        {
          //console.log($(this));// 取得圖片物件詳細資料
          //console.log($(this)[0].files[0]);// 取得圖片物件目標資料
          var file = $(this)[0].files[0];
          var save_path = "files/videos/";
          var form_data = new FormData();
          form_data.append("file", file); // append(key, value)
          form_data.append("save_path", save_path);
          $.ajax({
            type : 'POST',
            url : '../php/upload_file.php',
            data : form_data, // 上面的那個
            cache : false, // 因為只有上傳檔案, 所以不要暫存
            processData : false, // 因為只有上傳檔案, 不須處理表單資訊
            contentType : false, // 送過去的內容由 FormData 產生(決定格式為多型態)
            dataType : 'html'
          }).done(function(data){
            if(data == 'yes')// 顯示圖片
            {
              console.log(data);
              // 在這個 div 中引入 img
              $("div.showVideo")
              .html("<iframe class='embed-responsive-item' src='../" + save_path + file['name'] + "' allowfullscreen style='height: 300px;'></iframe>");
              // 把相對路徑存到 input hidden 中, 之後送出表單才可以抓到
              $("#videoPath").val(save_path + file['name']);

            }else
            {
              console.log(data);
            }
            //console.log(data);
          }).fail(function(jqXHR, textStatus, errorThrown){
            // 失敗的時候
            alert("有錯誤產生，請查看console log");
            console.log(jqXHR.responseText);
          });
        });
        // 影片刪除事件
        $("a.deleteVideo").click(function()
        {
          if($("#videoPath").val() != '')// 有圖片
          {
            var c = confirm("你確定要刪除嗎?此動作無法回復。");
            if(c)
            {
              $.ajax({
                type : 'POST',
                url : '../php/delete_file.php',
                data : {
                  'f' : $("#videoPath").val()
                },
                dataType : 'html'
              }).done(function(data){
                if(data == 'yes')// 清除圖片
                {

                  // 在這個 div 中引入 img
                  $("div.showVideo").html("");
                  // 清除相對路徑
                  $("#videoPath").val();
                  // 已選擇的 input 也要清掉
                  $("#videoInput").val('');
                  //console.log(data);
                }else {
                  //console.log(data);
                }
              }).fail(function(jqXHR, textStatus, errorThrown){
                // 失敗的時候
                alert("有錯誤產生，請查看console log");
                console.log(jqXHR.responseText);
              });
            }
          }else // 無圖片
          {
            alert("尚未上傳檔案，無法刪除。");
          }
        });

        // 因為form id是唯一的, 所以可以將 form#registerForm 省略成 #registerForm
        $("#workForm").submit(function(){
          if($("#introArea").val() == '')
          {
            alert("請填寫標題。");
          }else if($("#imageInput").val() == '' && $("#videoInput").val() == '')
          {
            alert("請上傳檔案。");
          }else if($("#imageInput").val() != '' && $("#videoInput").val() != '')
          {
            alert("只能選擇上傳一種檔案。");
          }else{
            // 先擋下來用 ajHX 去送給 add_user.php
            $.ajax({// 要傳送的包裹
              type : "post",// 在後端用表單送出去
              url : "../php/add_work.php",// 要送給誰處理
              data :
              {
                'i' : $("#introArea").val(),// 傳送一個變數 un(代表name), 把 $(this).val() 的值丟進去
                'ip' : $("#imagePath").val(),
                'vp' : $("#videoPath").val(),
                'p' : $("input[name='publish']:checked").val()//input 那個區塊中 name=publish 的, 被選到的那個
              },
              dataType : 'html' // check_username.php處理完後應該回傳html式
            }).done(function(data)
            {// 有正常接收訊息, 回傳的訊息叫作 data
              if(data == 'yes')
              {
                // 登入成功
                console.log(data);
                alert("新增成功，點擊確認回到列表頁。");
                window.location.href = "work_list.php";
              }else
              {
                console.log(data);
                alert("新增失敗，請檢查網路連線。");
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
