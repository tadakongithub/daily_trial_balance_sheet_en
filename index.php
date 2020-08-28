<?php

    session_start();
    require 'lang.php';

    if($_SESSION['logged_in'] != 'logged_in') {
        header('Location: login.php');
    }

    unset($_SESSION['admin_logged_in']);
?>

<html>
    <head>
        <?php require 'head.php'; ?>
    </head>
    <body class="flex-body">
        <div class="ui two item menu">
            <a class="item" href="admin-login.php"><?php checkLang('Admin', '管理画面');?></a>
            <a class="item" href="logout.php"><?php checkLang('Log Out', 'ログアウト');?></a>
        </div>
        <div class="home-container">
            <a href="./iba/date.php" class="to-form"><?php checkLang('Form', 'フォームへ');?></a>
        </div>
        
    </body>
</html>