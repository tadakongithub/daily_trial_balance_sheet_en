<?php
    session_start();
    require 'lang.php';
?>
<html>
    <head>
        <?php require 'head.php'; ?>
       
    </head>
    <body>
        <div class="branch_added_container">
            <div class="success-message"><?php checkLang('New Branch Was Added', '新しい店舗が追加されました。');?></div>
            <a href="admin-dashboard.php" class="back_to_top"><?php checkLang('Back to Admin Top', '管理画面に戻る');?></a>
        </div>
    </body>
</html>