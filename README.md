[Final Project] Cross-site request forgery (CSRF)
===
###### tags: `ISS`
# 資料夾說明
## 0_Original
包含原始的部落格網站(/13)以及測試攻擊的惡意網站(/testDelete)網頁原始碼，將(/13)及(/testDelete)複製到(\xampp\htdocs)路徑下。

## 1_CsrfToken
隨機生成一組token，存在SERVER端的SESSION當中，將資料夾內容取代(\xampp\htdocs)的檔案即可。

## 2_DoubleSubmitCookie
隨機生成一組token，存在CLIENT端的COOKIE當中，將資料夾內容取代(\xampp\htdocs)的檔案即可。

## 3_Fusion
隨機生成一組token，同時存在SERVER端的SESSION與CLIENT端的COOKIE當中，將資料夾內容取代(\xampp\htdocs)的檔案即可。


# CSRF介紹
跨站請求偽造（CSRF）又稱為 one-click attack 或者 session riding，攻擊者通過一些技術**欺騙用戶的瀏覽器去存取一個自己曾經認證過的網站並執行一些操作**。

## 情境舉例
被害者使用一個網購網站時選擇記住網購帳號密碼。在被害者登出網頁之前，打開了LINE，點開一則優惠券連結，結果他的帳號跟密碼就被盜取了，駭客可以利用這組帳號密碼登入，拿到該用戶更私密的訊息(地址、身分證、手機號碼、信用卡號)。

又舉另一個例子，有一個網紅，或者公眾人物，他在登入他的社群網站後，又去逛其他網站，他被一則廣告吸引，然後點進去查看，結果他的帳密就被盜取了，這時駭客取得他的帳密，然後利用他的帳號發文，分享了一則惡意連結，粉絲不疑有他，看到連結就點進去，結果資料被駭客取得。

[情境影片](https://youtu.be/-o8Ux4K9Rmc)

# 想達成的目標
以一個部落格網站為例，我們建立一個部落格網站，會員可以撰寫文章，編輯文章，刪除文章。

而駭客觀察文章編輯頁面的程式碼(F12)找到刪除文章所需要的關鍵欄位，並**撰寫惡意腳本嵌入在廣告中來傳送假的要求給部落格網站，讓會員在點擊廣告時刪除文章**。

防禦機制為**利用伺服端建立一個token，並存在伺服器端(session)，在編輯文章頁面裡才會生成這個token，並利用php將這個token隱藏，避免駭客利用CSRF攻擊**。

# 防禦的手法介紹
## 1. 檢查 Referer
透過檢查 request 的 header 中的 **referer 欄位是否為合法 domain** 來抵擋攻擊。
> referer 代表這個 request 是從哪個 domain 所發出的

## 2. 圖形、簡訊驗證碼
透過圖形、簡訊驗證碼來確認身分，駭客不知道答案的話就無法攻擊。

## 3. CSRF-Token
**有些資訊只有使用者才知道**

在 SERVER 端的 SESSION 以及 **CLIENT 端的 form 之 hidden 欄位**存放一組相同且隨機生成的 token，CLIENT 端 POST 時會送出這組 token，**SERVER 端比對收到的 token (form中的)與 SERVER 端所存的有無一致**，才會執行服務。

駭客不知道這組token值，就無法進行攻擊。

## 4. Double Submit Cookie
**Cookie是由domain寫下的**

由網站替 CLIENT 端寫下一組名為 token 的 Cookie，同時也加在 CLIENT 端的 form 中，SERVER 端再去比對收到的 token (form中的)與 Cookie 所存的有無一致。

當然駭客可以在 form 中帶上 token，但是**因瀏覽器的限制，駭客不能在他的 domain 設定 SERVER端 domain 的 cookie**，所以駭客發上來的 request 的 cookie 裡面就沒有 token，無法進行攻擊。

## 5. SameSite Cookie
* Cookie
    一塊能暫時存放在使用者瀏覽器的資料，並可以被提取用來記錄使用者的狀態、差異化使用者的體驗以及後續追蹤行為。
* Site
    指的是有相同的 <domain name>.<public suffix>，例如：yahoo.com 就是一個 site。
    只要 site 的部分相同，子網域也會當作是同一個 site，例如：new.yahoo.com 和 finance.yahoo.com 是同一個 site。

* SameSite Cookie
    該Cookie只允許發送給**當時寫入這個Cookie的Site**，而對發送時有兩種模式可以選擇:
    1. Strict: 僅限 same-site request 才能夠帶有此 cookie。
    2. Lax: 全部的 same-site request 以及部分 cross-site request 能夠寫入 cookie。這裡的部分包含以下能送出 request 的網頁元件：<a>, <link rel="prerender">, <form method="GET">.

因此當駭客竊取到token，但是**若從Cross-Site發送的請求就無法帶上的該Cookie**，也就無法傳送token進行攻擊。

> 由於目前**並非所有瀏覽器都支援該功能，因此也有發展更完善的防禦需求之必要**。

## Ref: 
1. [讓我們來談談 CSRF](https://blog.techbridge.cc/2017/02/25/csrf-introduction/)
2. [Chrome 80 後針對第三方 Cookie 的規則調整 (default SameSite=Lax)](https://medium.com/@azure820529/chrome-80-%E5%BE%8C%E9%87%9D%E5%B0%8D%E7%AC%AC%E4%B8%89%E6%96%B9-cookie-%E7%9A%84%E8%A6%8F%E5%89%87%E8%AA%BF%E6%95%B4-default-samesite-lax-aaba0bc785a3)

# 完整的防禦流程
![防禦流程](https://i.imgur.com/DAO2qu0.png)

# 實作驗證
## 1. 先建立[駭客欲攻擊的部落格與目標文章]
### 網站架構圖
![](https://i.imgur.com/PQMMHMX.png)
### 刪除文章流程
![](https://i.imgur.com/LgIq9a2.png)

### 網頁_後台
這是一個部落格文章編輯頁面，會員可以在此頁面中撰寫文章，編輯文章，刪除文章。
> ![網頁_後台](https://i.imgur.com/9SDE154.png)

* 網頁原始碼
> ![網頁原始碼_後台](https://i.imgur.com/Wdaps30.png =80%x)

* 資料庫
> ![資料庫_文章](https://i.imgur.com/iYb7mQT.png)

我們假設[標題]**請刪除我**的文章是駭客要刪除的目標，
從網頁原始碼和資料庫中可以很清楚看到**該目標文章的id編號為87**。

### [原始]網頁程式碼
#### /admin/article_list.php
* ##### Header的部分
``` php
<?php
  require_once '../php/connectDB.php';
  require_once '../php/functions.php';
  if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == false)
  {
    header('Location: login.php');
  }
  $articles = get_all_article();
?>
```

> 會先檢查該用戶是否為**登入的狀態**。

* ##### 刪除按鈕的功能
``` php
  <td>
    <a href="article_edit.php?id=<?php echo "{$article['id']}"; ?>" class="btn btn-success">編輯</a>
    <a href="javascript:void(0);" 
    class="btn btn-danger del_article" 
    data-id="<?php echo "{$article['id']}"; ?>">刪除</a>
  </td>
```

> 透過echo "{$article['id']}"取得該文章的id。

* ##### POST刪除請求
``` php
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
            'i' : $(this).attr("data-id")
            // 文章id
          },
          dataType : 'html' // check_username.php處理完後應該回傳html式
        }).done(function(data)
        {// 有正常接收訊息, 回傳的訊息叫作 data
          if(data == 'yes')
          {
            // 登入成功

            this_tr.fadeOut();
            alert("刪除成功，點擊確認移除資料。");

          }else
          {

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
```

> 可以知道這個網頁**利用POST傳送刪除請求**，並憑藉 **'i'** 來決定要刪除哪篇文章。

#### php/delete_article.php
``` php
<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = delete_article($_POST['i']);
  if($check)
  {
    // 帳號存在
    echo "yes";
  }else
  {
    // 帳號不存在
    echo "no";
  }
?>
```

> 接受到刪除的請求後，根據 **'i'** 來刪除目標文章，執行functions.php的delete_article後並echo是否刪除成功。


## 2. 撰寫惡意腳本
撰寫一個駭客攻擊所採用的惡意腳本，佯裝成一個優惠廣告，欺騙用戶點擊。

![惡意圖片](https://i.imgur.com/3VLbEkS.png =80%x)
> 點擊圖片後會連到[某知名成衣品牌的官網](https://www.uniqlo.com/tw/?gclid=CjwKCAjw5cL2BRASEiwAENqAPvFIzONBhsBFg6kj6Jw2AoHeBtrtz--b9mX5twrfUrhRuVl3NLExnBoCbE4QAvD_BwE&gclsrc=aw.ds)

### 攻擊流程
![攻擊流程](https://i.imgur.com/x7lvyPT.png)

### [原始]網頁程式碼
#### testDelete/index.php
* 將目標文章id崁入POST的請求中
``` php
<!-- 惡意圖片 -->
<a href="javascript:void(0);" 
data-id="87" class="del_article">
<img src="https://i.imgur.com/fvJ5tsY.png"/></a>
```
* POST時執行目標主機中的刪除指令
``` php
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
                'mycsrftoken' : $(this).attr("csrf-token") // 傳送token
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
```

> 可以發現駭客把惡意代碼嵌入在圖片連結中，只要點擊圖片，表面上是連結到購買網站上，但實際上卻是刪除了部落格中的文章。

## 3. 防禦實作
我們將部落格網站、惡意網站以及防禦實作的原始碼放在[github](https://github.com/shauming1020/Cross-Site-Request-Forgery-CSRF)上。

### - 1. [CSRF Token]網頁程式碼
#### /admin/article_list.php
* ##### Header的部分補上
``` php
  // 啟用session
  session_start(); 
  
  // 在SESSION中設定一組隨機生成的Token 
  $answer = md5(mktime() * 1234);
  $_SESSION['token'] = $answer; // 只有SERVER自己知道這個值，並定期更新
```
* ##### 刪除按鈕的功能補上[csrf-token="<?php echo $answer; ?>"]
``` php
<td>
    <a href="article_edit.php?id=<?php echo "{$article['id']}"; ?>" class="btn btn-success">編輯</a>
    <a href="javascript:void(0);" 
    class="btn btn-danger del_article" 
    data-id="<?php echo "{$article['id']}"; ?>" 
    csrf-token="<?php echo $answer; ?>">刪除</a>
    <!-- 傳送一組與SESSION中相同的Token給刪除功能 -->
</td>
```
* ##### POST刪除請求時也送token
``` php
data :
{
    'i' : $(this).attr("data-id"),
    'mycsrftoken' : $(this).attr("csrf-token") // 傳送正確的token
},
```

#### php/delete_article.php
``` php
<?php
  require_once 'connectDB.php';
  require_once 'functions.php';
  $check = False;
  if (isset($_SESSION['token'])){
	if ($_POST['mycsrftoken'] == $_SESSION['token']) {
		$match = True;
		$check = delete_article($_POST['i']);
	}else {
		$match = False;
	}	
    // 收到的token應要與伺服器所設定的一致
    if($check && $match) 
    {
	  // 帳號存在
	echo "yes";
    }else
    {
	  // 帳號不存在
	echo "no";
    }	
  }else {
	echo "no";
  }
?>
```

> 先檢查SESSION**有無設置token**，再**比對POST的token是否與SESSION所存的token**相同。

### - 2. [Doule Submit Cookie]網頁程式碼
#### /admin/article_list.php
與[CSRF Token]相同，只需修改Header的部分

* ##### Header的部分
    用setcookie取代掉SESSION的地方。
    
``` php
  // 設定一組隨機生成的Token存放在客戶端的Cookie中
  $answer = md5(mktime() * 1234);
  setcookie("token", $answer, time()+2*24*60*60, "/"); // 48hr後過期
```
> 客戶端會擁有**該部落格網站所設定一組名為token的COOKIE**
>> ![Cookie_Demo](https://i.imgur.com/ecQLJYy.png)
>> 
> 我們未將網站上架，實驗環境為localhost。

#### php/delete_article.php
用_COOKIE取代掉_SESSION即可。

``` php
  if (isset($_COOKIE['token'])){
	if ($_POST['mycsrftoken'] == $_COOKIE['token']) {
		$match = True;
		$check = delete_article($_POST['i']);
	}else {
		$match = False;
	}	
```

### - 3. [SameSite Cookie]網頁原始碼
與[Double Submit Cookie]相同，只需修改以下部分。
#### /admin/article_list.php
``` php
$answer = md5(mktime() * 1234);
setcookie("token", $answer, 
['expires'=>time()+2*24*60*60, // 48hr後過期
'path'=>"/", 
'samesite'=>'Lax']); // None, Lax, Strict
```
> For PHP >= v7.3

### 實驗結果
![實驗結果](https://i.imgur.com/HlpnurF.png)
> 由於駭客無法得知確切的token值，因此無法成功執行攻擊。


## 4. [More Complexity] 我們提出的防禦方法
讓駭客**取得token的過程變得更艱難**。

### 駭客的進化
若能**駭入SERVER端或CLIENT端取得正確的token值**，即可成功攻擊。

1. **若SERVER支持cross origin的請求**，駭客在他的頁面發起一個請求，即可順利拿到存在SESSION中的token來進行攻擊。
2. 駭客若**掌握了任何一個subdomain**，就可以**幫SERVER端寫cookie**，進行順利攻擊。
Ref: [Double Submit Cookies vulnerabilities](https://security.stackexchange.com/questions/59470/double-submit-cookies-vulnerabilities)

### 我們[對網頁原始碼的保護]
我們重新設計網頁
1. **隱藏網站原始碼中的token值**
* 先前的寫法會於網站原始碼中顯示正確的token值
![隱藏前](https://i.imgur.com/qIcctwh.png)
> 其實這樣蠻容易被駭客盜取token的。

* 因此我們刪除上圖中[csrf-token="<?php echo $answer; ?>"]的部分，並於POST處修改成以下型式
``` php
  data :
  {
    'i' : $(this).attr("data-id"),
    'mycsrftoken' : <?php echo $answer;?>// 傳送正確的token
  },
```
> 如此一來即可隱藏網站中的token值。


2. **對暴露的token加密**
* 上述的結果還有一個風險，POST的token值也會在網站原始碼中顯示。

![加密前的POST token](https://i.imgur.com/ZPP2hNa.png)

* 因此我們**對此POST的token經公式變換後才作為正確的token**，當駭客取得POST的token值時，若不知道正確的公式變換也無法得到確切的token。

修改以下檔案
#### /admin/article_list.php
* ##### Header
``` php
// 設定一組隨機生成的Token存放在客戶端的Cookie中
$answer = mktime();
setcookie("token", md5($answer*1234), time()+2*24*60*60, "/"); // 48hr後過期  
```
> COOKIE中的token為POST的token($answer)乘上1234加密後的值

* ##### POST
``` php
  data :
  {
    'i' : $(this).attr("data-id"),
    'mycsrftoken' : <?php echo $answer;?>// 傳送正確的token
  },
```
> 駭客只能看到尚未變換前的token

#### php/delete_article.php

``` php
  if (isset($_COOKIE['token'])){
	  $a = $_POST['mycsrftoken'];
	  $a = md5($a*1234);
	if ($a == $_COOKIE['token']) {
		$match = True;
		$check = delete_article($_POST['i']);
	}else {
		$match = False;
	}
```
> 刪除時會先判斷POST的token**經變換後是否與COOKIE所存一致**

但是**當駭客能破解出PHP網站原始碼，就可以知道我們的加密流程**，因此也必須先對PHP原始碼進行保護，而這不在我們討論的範圍內。

### 難上加難
其實要取得token已經很不容易了，因此若讓取得token的整個過程變得更複雜，應能**使大部分駭客打消採用CSRF的攻擊手段**。

1. **同時使用**CSRF-Token與Double Submit Cookie的方法，或是再混用其他防護措施，增加破解難度。

#### /admin/article_list.php
``` php
// 設定一組隨機生成的Token存放在客戶端的Cookie中
$answer = mktime();
$_SESSION['token'] = md5($answer*1234); // 只有SERVER自己知道這個值，並定期更新
setcookie("token", md5($answer*1234), 
['expires'=>time()+2*24*60*60, // 48hr後過期
'path'=>"/", 
'samesite'=>'Lax']); // None, Lax, Strict
```

#### php/delete_article.php
``` php
  if (isset($_COOKIE['token']) and isset($_SESSION['token'])){
	  $a = $_POST['mycsrftoken'];
	  $a = md5($a*1234);
	if ($a == $_COOKIE['token'] and $a == $_SESSION['token']) {
		$match = True;
		$check = delete_article($_POST['i']);
	}else {
		$match = False;
	}
```

2. **週期性的更新**token值及加密的方法。

# 結論
我們架設了部落格網站來實驗各種有關CSRF的防禦機制，我們認為對於**尚未支援SameSite Cookie的瀏覽器**，可以針對**網站原始碼保護，如隱藏token、對token加密**，以及**混用CSRF的防禦機制**和**週期性更新token、加密方法**的手段，來讓駭客更難取得token進行攻擊。
