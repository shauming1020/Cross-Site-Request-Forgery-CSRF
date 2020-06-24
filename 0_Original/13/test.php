<?php
@session_start();
  require_once 'php/connectDB.php';

  function update_work($id, $intro, $imagePath, $videoPath, $publish)
  {
    $result = null;
    $upload_date = date("Y-m-d H:i:s");

    $work = get_edit_work($id);
    if(file_exists($work['image_path'])) // 如果舊的不是 null
    {
      if($imagePath != $work['image_path']) // 而且新的 != 舊的
      {
        unlink($work['image_path']); // 刪掉舊的
      }
    }
    if(file_exists($work['video_path'])) // 如果舊的不是 null
    {
      if($videoPath != $work['video_path']) // 而且新的 != 舊的
      {
        unlink($work['video_path']); // 刪掉舊的
      }
    }

    $image_path_sql = "`image_path`= 'NULL',";
    if($imagePath != '')
    {
      $image_path_sql = "`image_path` = '{$imagePath}',";
    }
    $vidoe_path_sql = "`video_path` = 'NULL',";
    if($videoPath != '')
    {
      $vidoe_path_sql = "`video_path`= '{$videoPath}',";
    }

    $sql_statement = "UPDATE `works` SET  `intro` = '{$intro}',
                                           {$image_path_sql}
                                           {$vidoe_path_sql}
                                           `upload_date` = '{$upload_date}' WHERE `id` = '{$id}';";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);

    if($query)
    {
      // 若 row 的數量有改變
      if(mysqli_affected_rows($_SESSION['link']) == 1)
      {
        $result = true;
      }
    }else
    {
      echo "{$sql_statement} 執行失敗, 錯誤訊息 : " . mysqli_error($_SESSION['link']);
      $result = "{$sql_statement} 執行失敗, 錯誤訊息 : " . mysqli_error($_SESSION['link']);
    }
    return $result;

  }
  
  echo "{$result}";
 ?>
