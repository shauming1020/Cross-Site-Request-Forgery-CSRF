# CSRF
## 0_Original
包含原始的部落格網站(/13)以及測試攻擊的惡意網站(/testDelete)網頁原始碼，將(/13)及(/testDelete)複製到(\xampp\htdocs)路徑下。

## 1_CsrfToken
隨機生成一組token，存在SERVER端的SESSION當中，將資料夾內容取代(\xampp\htdocs)的檔案即可。

## 2_DoubleSubmitCookie
隨機生成一組token，存在CLIENT端的COOKIE當中，將資料夾內容取代(\xampp\htdocs)的檔案即可。

## 3_Fusion
隨機生成一組token，同時存在SERVER端的SESSION與CLIENT端的COOKIE當中，將資料夾內容取代(\xampp\htdocs)的檔案即可。
