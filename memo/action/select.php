<?php
    require '../../common/auth.php';
    require '../../common/database.php';

    if (!is_login()) {
        header('Location: ../login/');
        exit;
    }

    $id = $_GET['id'];
    $user_id = get_login_user_id();

    $database_handler = get_database_connection();
    if ($statement = $database_handler->prepare("SELECT id, title, content FROM memos WHERE id = :id AND user_id = :user_id")) {
        $statement->bindParam(":id", $id);
        $statement->bindParam(":user_id", $user_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    }

    $_SESSION['select_memo'] = [
        'id' => $result['id'],
        'title' => $result['title'],
        'content' => $result['content']
    ];
    header('Location: ../../memo/');
    exit;
