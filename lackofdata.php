<?php
session_destroy();
?>
<html>
<head>
<?php require 'head.php'; ?>
</head>
<body class="flex-body">
    <div class="home-container">
    <div class="success-message">未入力のデータが会ったか、入力時間が長すぎたためページ
    を表示できませんでした。ログインからやり直してください。</div>
    <a href="index.php" class="back_to_top">トップページに戻る</a>
    </div>
</body>
</html>