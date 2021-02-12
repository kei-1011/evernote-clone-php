<?php
    require '../../common/auth.php';
    require '../../common/database.php';

    if (!is_login()) {
        header('Location: ../login/');
        exit;
    }

    $edit_id = $_POST['edit_id'];
    $user_id = get_login_user_id();

    $database_handler = get_database_connection();

    try {
        if ($statement = $database_handler->prepare("DELETE FROM memos WHERE id = :edit_id AND user_id = :user_id")) {
            $statement->bindParam(":edit_id", $edit_id);
            $statement->bindParam(":user_id", $user_id);
            $statement->execute();
        }
    } catch (Throwable $e) {
        echo $e->getMessage();
        exit;
    }

    unset($_SESSION['select_memo']);

    header('Location: ../../memo');
    exit;
