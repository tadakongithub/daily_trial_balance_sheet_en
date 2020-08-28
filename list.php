<?php

session_start();

require 'db.php';
require 'lang.php';

//all data in ibaraki table
$results = $myPDO->query('SELECT * FROM okasato');

//データベースにある全ての「年-月」の組み合わせを配列に入れる
$yearMonthArray = array();
while($result = $results->fetch()) {
    $timestamp = strtotime($result['date']);
    $value = date('Y-m', $timestamp);
    if(!in_array($value, $yearMonthArray)) {
        $yearMonthArray[] = $value;
    }
}

?>
<html>
<head>
    <?php require 'head.php'; ?>
    <script>
        $(document).ready(function(){
            $('.select.dropdown').dropdown();
        });
    </script>
</head>
<body class="flex-body">
    <div class="ui pointing stackable menu">
        <a class="item" href="admin-dashboard.php"><?php checkLang('Admin Top', '管理トップ');?></a>
        <a class="item" href="admin-pass.php"><?php checkLang('Change Branch Password', '店舗パス変更');?></a>
        <a class="item" href="add_branch.php"><?php checkLang('Add Branch', '店舗追加');?></a>
        <div class="right menu">
            <a class="ui item" href="admin-logout.php"><?php checkLang('Log Out', 'ログアウト');?></a>
        </div>
    </div>

    <div class="home-container">
        <form action="download.php" method="post" class="ui form">
            <div class="field">
                <label for="branch"><?php checkLang('Branch', '店舗を選ぶ');?></label>
                <select name="branch" id="branch" class="ui select dropdown">
                    <?php foreach($myPDO->query('SELECT * FROM branch_list') as $row):?>
                        <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                    <?php endforeach ;?>
                </select>
            </div>
                
            <div class="field">
                <label for="yearMonth"><?php checkLang('Month', '月を選ぶ');?></label>
                <select name="yearMonth" id="yearMonth" class="ui select dropdown">
                    <?php foreach($yearMonthArray as $yearMonth):?>
                        <option value="<?php echo $yearMonth;?>"><?php echo $yearMonth;?></option>
                    <?php endforeach;?>
                </select>
            </div>
                   
            <button id="start_download" type="submit"><?php checkLang('Download', 'ダウンロード開始');?></button>
            
        </form>
    </div>               |
</body>
</html>
