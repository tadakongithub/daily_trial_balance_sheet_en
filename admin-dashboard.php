<?php

session_start();

if(!$_SESSION['admin_logged_in']) {
    header('Location: index.php');
}

require 'lang.php';

?>

<html>
<head>
    <?php require 'head.php'; ?>
</head>

<body class="flex-body">
    <div class="ui pointing stackable menu">
        <a class="item" href="admin-pass.php"><?php checkLang('Change Branch Password', '店舗パス変更'); ?></a>
        <a class="item" href="list.php"><?php checkLang('Download', 'ダウンロード'); ?></a>
        <a class="item" href="add_branch.php"><?php checkLang('Add Branch', '店舗追加'); ?></a>
        <div class="right menu">
            <a class="ui item" href="admin-logout.php"><?php checkLang('Log Out', 'ログアウト'); ?></a>
        </div>
    </div>
</body>
</html>