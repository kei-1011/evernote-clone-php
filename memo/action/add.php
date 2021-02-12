<?php
  require '../../common/auth.php';
  require '../../common/database.php';

  if (!is_login()) {
      header('Location: ../login/');
      exit;
  }

  $user_id = get_login_user_id();
  $database_handler = get_database_connection();

  try {
      $title = "新規メモ";
      if ($statement = $database_handler->prepare("INSERT INTO memos (user_id, title, content) VALUES(:user_id, :title, null)")) {
          $statement->bindParam(":user_id", $user_id);
          $statement->bindParam(":title", $title);
          $statement->execute();
      }

      $_SESSION['select_memo'] = [
          'id' => $database_handler->lastInsertId(),
          'title' => $title,
          'content' => '',
      ];
  } catch (Throwable $e) {
      echo $e->getMessage();
      exit;
  }
  header('Location: ../../memo');
  exit;
