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
    <div class="success-message"><?php checkLang('Data Submitted', 'データが送信されました。');?></div>
    <a href="index.php" class="back_to_top"><?php checkLang('Back to Top', 'トップページに戻る');?></a>
    </div>
</body>
</html>