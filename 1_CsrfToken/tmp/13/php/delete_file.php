<?php
  //如果檔案存在就刪除
  if(file_exists("../".$_POST['f']))
  {
    // unlink 刪除檔案
    if(unlink("../".$_POST['f']))
    {
      echo "yes";
    }else
    {
      echo "刪除失敗";
    }
  }else {
    echo "檔案不存在";
  }
?>
