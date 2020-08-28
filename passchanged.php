<?php
    session_start();
    require 'lang.php';
?>
<html>
    <head>
        <?php require 'head.php'; ?>
    </head>
    <body class="flex-body">
        <div class="home-container">
            <div class="success-message"><?php checkLang('Password Changed', 'パスワードが変更されました。');?></div>
            <a href="admin-dashboard.php" class="back_to_top"><?php checkLang('Back to Admin Top', '管理画面に戻る');?></a>
        </div>
    </body>
</html>