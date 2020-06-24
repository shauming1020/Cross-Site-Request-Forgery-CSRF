<?php

    /**
    ***** 檔案的陣列有以下索引值
    * $_FILES['設定的 name']['name'] 原本的檔名
    * $_FILES['設定的 name']['tmp_name'] 存在sever上的檔名, 會被重新命名
    * $_FILES['設定的 name']['type'] 檔案型態
    * $_FILES['設定的 name']['size'] 檔案大小
    * $_FILES['設定的 name']['error'] 錯誤代碼
    */

    //如果有傳 photo 索引值的檔案過來
    //檢查上傳到server的暫存檔是否存在
    if(file_exists($_FILES['file']['tmp_name']))
    {
      //定義要上傳到的資料夾
        $targetFolder = $_POST['save_path'];
        $fileName = $_FILES['file']['name'];
        // 如果存在就搬移檔案, move_uploaded_file 是將上傳的檔案移動到網站資料夾正確定義的位置
        // 第一個變數通常是上傳後暫存的檔案位置, 第二個變數是搬移的目標檔案及位置
        // $targetFolder.$fileName 等同 files/images/圖檔名稱.jpg
        // 由於 work_save.php 這支檔案在 php 資料夾中, 但圖檔是要上傳到上一層找到 files 資料夾, 所以
        if(move_uploaded_file($_FILES['file']['tmp_name'], "../".$targetFolder.$fileName))
        {
          echo "yes";
          //echo "{$photo}";
        }else
        {
          echo "檔案搬移失敗, 請確認{$_POST['save_path']}資料夾可寫入";
        }

    }else
    {
        //如果檔案不存在
        echo "上傳失敗，暫存檔不存在。請確認資料夾寫入權限，或php.ini上傳檔案容量限制是否太小。";
        phpinfo();
    }
?>
