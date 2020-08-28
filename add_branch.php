<?php
    session_start();

    require 'db.php';
    require 'lang.php';

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
        <a class="item" href="admin-dashboard.php"><?php checkLang('Admin Top', '管理トップ');?></a>
        <a class="item" href="admin-pass.php"><?php checkLang('Change Branch Password', '店舗パス変更');?></a>
        <a class="item" href="list.php"><?php checkLang('Download', 'ダウンロード');?></a>
        <div class="right menu">
            <a class="ui item" href="admin-logout.php"><?php checkLang('Log Out', 'ログアウト');?></a>
        </div>
    </div>

        <div class="home-container">
            <form action="" method="post" class="ui form">
                <div class="field">
                    <label for="branch_name"><?php checkLang('New Branch Name', '新しい店舗名');?></label>
                    <input type="text" name="branch_name" id="branch_name" required>
                </div>

                <div class="field">
                    <label for="newpass"><?php checkLang('Password', 'パスワードを設定');?></label>
                    <input type="password" name="newpass" id="newpass"  required>
                </div>

                <button class="submit-btn" type="submit"><?php checkLang('Send', '送信');?></button>
            </form>
        </div>
    </body>
</html>