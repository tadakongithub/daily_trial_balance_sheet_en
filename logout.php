<?php

session_start();

require 'lang.php';

session_destroy();

?>

<html>
<head>
<?php require 'head.php'; ?>
</head>
<body  class="flex-body">
    <div class="home-container">
    <div class="success-message"><?php checkLang('Logged Out', 'ログアウトしました');?></div>
    <a href="login.php" class="back_to_top"><?php checkLang('Log In', 'ログインする');?></a>
    </div>
</body>
</html>