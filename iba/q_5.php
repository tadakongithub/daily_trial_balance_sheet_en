<?php
    session_start();
    require '../lang.php';

    if(!$_SESSION['logged_in'] == 'logged_in') {
        header('Location: ../index.php');
    }

    if(isset($_POST['next']) || isset($_POST['back'])) {
        if($_POST['sent_to'][0] === '' || $_POST['total_sent'][0] === '' || $_POST['content_sent'][0] === ''){
            if($_POST['next']){
                header('Location: q_6_7_8.php');
            } else if($_POST['back']){
                header('Location: q_4.php');
            }
        } else {
            $_SESSION['sent_to'] = $_POST['sent_to'];
            $_SESSION['total_sent'] = $_POST['total_sent'];
            $_SESSION['content_sent'] = $_POST['content_sent'];
            if($_POST['next']){
                header('Location: q_6_7_8.php');
            } else if($_POST['back']){
                header('Location: q_4.php');
            }
        }
        
    }

    require 'back_to_top_handling.php';
?>
<html>
<head>
<?php require './form-head.php';?>
</head>
<body>
    <div class="q-container-add">
        <h1 class="ui header"><?php echo $_SESSION['branch'];?>　<?php checkLang('', '日計表');?></h1>
            <form action="" method="post" id="form_received" class="ui form">
            <h2 class="ui header" id="sent_h2">5. <?php checkLang('Cash Spent at Cash Counter', '現金の<span class="sent_red">レジ出金</span>を記入してください。');?></h2>
            <h3 class="ui header">（<?php checkLang('Purchase of Consumables or Cooking Ingredients, Employment Cost on Helpers', '消耗品購入・食材仕入・お手伝いスタッフの人件費など');?>）</h3>

            <div class="input_fields_wrapper">
            <?php if(isset($_SESSION['sent_to'])):?>
                <?php for($i = 0; $i < count($_SESSION['sent_to']); $i++):?>
                <div class="each-sent">
                    <div class="icon-container">
                        <image class="remove_field" src="../img/close.png" alt="<?php checkLang('Delete', '削除');?>">
                    </div>
                    <div class="each-field field">
                        <label for="sent_to"><?php checkLang('Where Purchase was Made', '購入先・スタッフ名など');?></label>
                        <small class="warning"><?php checkLang('Notice: Please provide the official name', '※注意※　×シェル→〇関東礦油&nbsp;&nbsp;ブランド名ではなく、会社名を記載してください。');?></small>
                        <input type="text" name="sent_to[]" id="sent_to" value="<?php echo $_SESSION['sent_to'][$i];?>" required>
                    </div>
                    
                    <div class="each-field field">
                        <label for="total_sent"><?php checkLang('Amount of Money Spent', '出金額');?></label>
                        <input type="number" name="total_sent[]" id="total_sent" value="<?php echo $_SESSION['total_sent'][$i];?>" required>
                    </div>
                    
                    <div class="each-field field">
                        <label for="content_sent"><?php checkLang('Items or Services Purchased', '出金の内容');?></label>
                        <input type="text" name="content_sent[]" id="content_sent" value="<?php echo $_SESSION['content_sent'][$i];?>" required>
                    </div> 
                </div>
                <?php endfor;?>
            <?php else :?>
                <div class="each-sent">
                    <div class="each-field field">
                        <label for="sent_to"><?php checkLang('Where Purchase was Made', '購入先・スタッフ名など');?></label>
                        <small class="warning"><?php checkLang('Notice: Please provide the official name', '※注意※　×シェル→〇関東礦油&nbsp;&nbsp;ブランド名ではなく、会社名を記載してください。');?></small>
                        <input type="text" name="sent_to[]" id="sent_to" placeholder="<?php checkLang('Blank if No Transaction', '取引なしは入力しない'); ?>">
                    </div>
                    
                    <div class="each-field field">
                        <label for="total_sent"><?php checkLang('Amount of Money Spent', '出金額');?></label>
                        <input type="number" name="total_sent[]" id="total_sent" placeholder="<?php checkLang('Blank if No Transaction', '取引なしは入力しない'); ?>">
                    </div>
                    
                    <div class="each-field field">
                        <label for="content_sent"><?php checkLang('Items or Services Purchased', '出金の内容');?></label>
                        <input type="text" name="content_sent[]" id="content_sent" placeholder="<?php checkLang('Blank if No Transaction', '取引なしは入力しない'); ?>">
                    </div> 
                </div>
            <?php endif;?>
            </div>

            <div class="add-container">
                <img class="add_button" src="../img/plus.png" alt="<?php checkLang('Add', '追加'); ?>">
            </div>
            
            <div class="back_next_container">
                <input type="submit" name="next" value="<?php checkLang('Next', '次へ');?>" class="next_button"/>
                <?php if(isset($_SESSION['went_to_confirmation'])):?>
                <input type="submit" name="back" value="<?php checkLang('Back', '戻る');?>" class="back_button"/>
                <?php else:?>
                <a href="q_4.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
                <?php endif ;?>
            </div>
            <?php require 'back_to_top.php';?>
    </form>

    <?php require 'back_to_top_modal.php';?>

    <script>
        $(document).ready(function(){
            var add_button = $(".add_button");
            var wrapper = $(".input_fields_wrapper");

            var lang = '<?php echo $lang; ?>';
            if(lang == 'eng'){
                var label_1 = 'Where Purchase was Made';
                var notice = 'Notice: Please provide the official name';
                var label_2 = 'Amount of Money Spent';
                var label_3 = 'Items or Services Purchased';
            } else {
                var label_1 = '取引先・スタッフなど';
                var notice = '※注意※　×シェル→〇関東礦油&nbsp;&nbsp;ブランド名ではなく、会社名を記載してください。';
                var label_2 = '出金額';
                var label_3 = '出金内容';
            }

            $(add_button).click(function(){
                $(wrapper).append(
                    '<div class="each-sent">' +
                    '<div class="icon-container">' +
                    '<image class="remove_field" src="../img/close.png" alt="">' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="sent_to">' + label_1 + '</label>' +
                    '<small class="warning">' + notice + '</small>' +
                    '<input type="text" name="sent_to[]" id="sent_to" required>' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="total_sent">' + label_2 + '</label>' +
                    '<input type="number" name="total_sent[]" id="total_sent" required>' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="content_sent">' + label_3 + '</label>' +
                    '<input type="text" name="content_sent[]" id="content_sent" required>' +
                    '</div>' +
                    '</div>'
                );
            });

            $(wrapper).on('click', '.remove_field', function(e){
                e.preventDefault();
                $(this).parent('div').parent('div').remove();
            });
        });
    </script>
</body>
</html>