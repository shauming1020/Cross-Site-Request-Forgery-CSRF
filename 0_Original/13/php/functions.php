<?php
  // @ 避免同時使用時衝撞
  @session_start();

  function get_publish_article()
  {
    $data = array();

    $sql_statement = "SELECT * FROM `article` WHERE `publish` = 1;";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) > 0)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          // $row 是陣列資料，包含每個 id 對應到的所有值
          while ($row = mysqli_fetch_assoc($query))
          {
            $data[] = $row;
          }
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $data;
  }
  function get_article($getId)
  {

    $article = null;

    $sql_statement = "SELECT * FROM `article` WHERE `publish` = 1 AND `id` = {$getId};";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) == 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $article = mysqli_fetch_assoc($query);
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $article;
  }
  function get_publish_work()
  {
    $data = array();

    $sql_statement = "SELECT * FROM `works` WHERE `publish` = 1;";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) > 0)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          // $row 是陣列資料，包含每個 id 對應到的所有值
          while ($row = mysqli_fetch_assoc($query))
          {
            $data[] = $row;
          }
      }

    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $data;
  }
  function get_work($getId)
  {

    $work = null;

    $sql_statement = "SELECT * FROM `works` WHERE `publish` = 1 AND `id` = {$getId};";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) == 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $work = mysqli_fetch_assoc($query);
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $work;
  }
  function check_has_username($username)
  {

    $result = null;

    $sql_statement = "SELECT * FROM `user` WHERE `username` = '{$username}';";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) >= 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $result = true;
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $result;
  }
  function add_user($name, $username, $password)
  {
    $result = false;
    $password = md5($password); // 加密
    $sql_statement = "INSERT INTO `user` (`name`, `username`, `password`)
                    VALUE ('{$name}', '{$username}', '{$password}');";
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
    }
    return $result;

  }
  function verify_user($username, $password)
  {

    $result = null;
    $password = md5($password);
    $sql_statement = "SELECT * FROM `user` WHERE `username` = '{$username}'
                      AND `password` = '{$password}';";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) >= 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $result = true;

          $user = mysqli_fetch_assoc($query);
          $_SESSION['is_login'] = true;
          $_SESSION['login_user_id'] = $user['id'];
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $result;
  }
  function get_all_article()
  {
    $data = array();

    $sql_statement = "SELECT * FROM `article`;";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) > 0)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          // $row 是陣列資料，包含每個 id 對應到的所有值
          while ($row = mysqli_fetch_assoc($query))
          {
            $data[] = $row;
          }
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $data;
  }
  function add_article($title, $category, $content, $publish)
  {
    $result = false;
    $create_date = date("Y-m-d H:i:s");
    $creater_id = $_SESSION['login_user_id'];// 在 verify_user() 中會建立這個 $_SESSION
    $sql_statement = "INSERT INTO `article` (`title`, `category`, `content`, `publish`, `create_date`, `creater_id`)
                    VALUE ('{$title}', '{$category}', '{$content}', '{$publish}', '{$create_date}', '{$creater_id}');";
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
    }
    return $result;

  }
  function get_edit_article($getId)
  {

    $article = null;

    $sql_statement = "SELECT * FROM `article` WHERE `id` = {$getId};";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) == 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $article = mysqli_fetch_assoc($query);
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $article;
  }
  function update_article($id, $title, $category, $content, $publish)
  {
    $result = false;
    $modify_date = date("Y-m-d H:i:s");
    $sql_statement = "UPDATE `article` SET `title` = '{$title}',
                                           `category` = '{$category}',
                                           `content`= '{$content}',
                                           `publish` = '{$publish}',
                                           `modify_date` = '{$modify_date}' WHERE `id` = '{$id}';";
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
    }
    return $result;

  }
  function delete_article($id)
  {
    $result = false;

    $sql_statement = "DELETE FROM `article` WHERE `id` = '{$id}';";
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
    }
    return $result;

  }
  function get_all_member()
  {
    $data = array();

    $sql_statement = "SELECT * FROM `user`;";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) > 0)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          // $row 是陣列資料，包含每個 id 對應到的所有值
          while ($row = mysqli_fetch_assoc($query))
          {
            $data[] = $row;
          }
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $data;
  }
  function delete_member($id)
  {
    $result = false;

    $sql_statement = "DELETE FROM `user` WHERE `id` = '{$id}';";
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
    }
    return $result;

  }
  function get_edit_member($getId)
  {

    $member = null;

    $sql_statement = "SELECT * FROM `user` WHERE `id` = {$getId};";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) == 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $member = mysqli_fetch_assoc($query);
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $member;
  }
  function update_member($id, $name, $username, $password)
  {
    $result = false;
    $password_sql = '';
    if($password != '')
    {
      $password = md5($password);
      $password_sql = ", `password` = '{$password}'";
    }
    $sql_statement = "UPDATE `user` SET `name` = '{$name}',
                                           `username` = '{$username}'
                                            {$password_sql} WHERE `id` = '{$id}';";
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
    }
    return $result;

  }
  function get_all_work()
  {
    $data = array();

    $sql_statement = "SELECT * FROM `works`;";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) > 0)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          // $row 是陣列資料，包含每個 id 對應到的所有值
          while ($row = mysqli_fetch_assoc($query))
          {
            $data[] = $row;
          }
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $data;
  }
  function add_work($intro, $imagePath, $videoPath, $publish)
  {
    $result = false;
    $upload_date = date("Y-m-d H:i:s");
    $creater_id = $_SESSION['login_user_id'];// 在 verify_user() 中會建立這個 $_SESSION

    $image_path_sql = "NULL";
    if($imagePath != '')
    {
      $image_path_sql = "'{$imagePath}'";
    }
    $vidoe_path_sql = "NULL";
    if($videoPath != '')
    {
      $vidoe_path_sql = "'{$videoPath}'";
    }

    $sql_statement = "INSERT INTO `works` (`intro`, `image_path`, `video_path`, `publish`, `upload_date`, `create_user_id`)
                    VALUE ('{$intro}', {$image_path_sql}, {$vidoe_path_sql}, '{$publish}', '{$upload_date}', '{$creater_id}');";
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
    }
    return $result;

  }
  function get_edit_work($getId)
  {

    $work = null;

    $sql_statement = "SELECT * FROM `works` WHERE `id` = {$getId};";
    // 其他例子 : $sql_statement = "SELECT `username`, `name` FROM `users` WHERE `id` = 6;";
    //mysqli_query(資料庫連線, "sql語法");
    $query = mysqli_query($_SESSION['link'], $sql_statement);
    // 如果 query 請求成功
    if($query)
    {
      // 使用 mysqli_num_rows() 判別其取得的資料量是否大於 0 (是否存在)
      // mysqli_num_rows() 回傳查到多少筆資料
      if(mysqli_num_rows($query) == 1)
      {
          // 如果有資料
          // mysqli_fetch_assoc() 執行第一次，顯示第一筆資料，執行第二次，顯示第二筆資料
          $work = mysqli_fetch_assoc($query);
      }
    }else
    {
      // mysqli_error() 請求出現錯誤時使用
      echo "sql語法請求失敗, 錯誤訊息 : ".mysqli_error($_SESSION['link']);
    }
    return $work;
  }
  function update_work($id, $intro, $imagePath, $videoPath, $publish)
  {
    $result = false;
    $upload_date = date("Y-m-d H:i:s");

    $work = get_edit_work($id);
    if(file_exists("../".$work['image_path'])) // 如果舊的不是 null
    {
      if($imagePath != $work['image_path']) // 而且新的 != 舊的
      {
        unlink("../".$work['image_path']); // 刪掉舊的
      }
    }
    if(file_exists("../".$work['video_path'])) // 如果舊的不是 null
    {
      if($videoPath != $work['video_path']) // 而且新的 != 舊的
      {
        unlink("../".$work['video_path']); // 刪掉舊的
      }
    }

    $image_path_sql = '`image_path`= "NULL", ';
    if($imagePath != '')
    {
      $image_path_sql = "`image_path` = '{$imagePath}', ";
    }
    $vidoe_path_sql = '`video_path` = "NULL", ';
    if($videoPath != '')
    {
      $vidoe_path_sql = "`video_path`= '{$videoPath}', ";
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

    }
    return $result;

  }
  function delete_work($id)
  {
    $result = false;
    $work = get_edit_work($id);
    if(file_exists("../".$work['image_path'])) // 如果舊的不是 null
    {
      unlink("../".$work['image_path']); // 刪掉舊的
    }
    if(file_exists("../".$work['video_path'])) // 如果舊的不是 null
    {
      unlink("../".$work['video_path']); // 刪掉舊的
    }

    $sql_statement = "DELETE FROM `works` WHERE `id` = '{$id}';";
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
    }
    return $result;

  }
?>
