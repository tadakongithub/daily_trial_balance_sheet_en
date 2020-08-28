<?php

session_start();

session_destroy();

?>

<html>
<head>
<?php require 'head.php'; ?>
</head>
<body  class="flex-body">
    <div class="home-container">
    <div class="success-message">ログアウトしました</div>
    <a href="login.php" class="back_to_top">ログインする</a>
    </div>
</body>
</html>