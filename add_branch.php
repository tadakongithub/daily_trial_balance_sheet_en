<?php
    session_start();

    require 'db.php';

    if($_POST) {
        $statement = $myPDO->prepare('INSERT INTO branch_list (name, password) VALUES (:name, :password)');
        $statement->execute(array(
            ':name' => $_POST['branch_name'],
            ':password' => password_hash($_POST['newpass'], PASSWORD_BCRYPT)
        ));
        header('Location: branch_added.php');
    }
    
?>

<html>
<head>
        <?php require 'head.php'; ?>
    </head>
    <body class="flex-body">
    <div class="ui pointing stackable menu">
        <a class="item" href="admin-dashboard.php">管理トップ</a>
        <a class="item" href="admin-pass.php">店舗パス変更</a>
        <a class="item" href="list.php">ダウンロード</a>
        <div class="right menu">
            <a class="ui item" href="admin-logout.php">ログアウト</a>
        </div>
    </div>

        <div class="home-container">
            <form action="" method="post" class="ui form">
                <div class="field">
                    <label for="branch_name">新しい店舗名</label>
                    <input type="text" name="branch_name" id="branch_name" required>
                </div>

                <div class="field">
                    <label for="newpass">パスワードを設定</label>
                    <input type="password" name="newpass" id="newpass"  required>
                </div>

                <button class="submit-btn" type="submit">送信</button>
            </form>
        </div>
    </body>
</html>