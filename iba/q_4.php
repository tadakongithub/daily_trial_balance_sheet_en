<?php
    session_start();
    require '../lang.php';

    if(!$_SESSION['logged_in'] == 'logged_in') {
        header('Location: ../index.php');
    }

    if(isset($_POST['next']) || isset($_POST['back'])) {
        if($_POST['received_from'][0] === '' || $_POST['total_received'][0] === '' || $_POST['content_received'][0] === ''){
            if($_POST['next']){
                header('Location: q_5.php');
            } else if($_POST['back']){
                header('Location: q_1_3.php');
            }
        } else {
            $_SESSION['received_from'] = $_POST['received_from'];
            $_SESSION['total_received'] = $_POST['total_received'];
            $_SESSION['content_received'] = $_POST['content_received'];
            if($_POST['next']){
                header('Location: q_5.php');
            } else if($_POST['back']){
                header('Location: q_1_3.php');
            }
        }
        
    }

    require 'back_to_top_handling.php';
?>
<html>
<head>
<?php require './form-head.php';?>
<script>
    $(document).ready(function(){
        if($(window).width() < 480) {
            $('i.plus.square.icon.big').removeClass('big').addClass('massive');
        }
    });
</script>
</head>
<body>

    <div class="q-container-add">
        <h1 class="ui header"><?php echo $_SESSION['branch'];?>　<?php checkLang('', '日計表');?></h1>
        <form action="" method="post" id="form_received" class="ui form">
            <h2 class="ui header" id="received_h2">4. <?php checkLang('Cash Received at Checkout Counter', '現金の<span class="received_blue">レジ入金</span>を記入してください。');?></h2>
            <h3 class="ui header">（<?php checkLang('Tax of Clients or Our Helpers Collected at the Source', '取引先・お手伝いスタッフの源泉税など');?>）</h3>
            <div class="input_fields_wrapper">
            <?php if(isset($_SESSION['received_from'])):?>
                <?php for($i = 0; $i < count($_SESSION['received_from']); $i++):?>
                    <div class="each-received">
                        <div class="icon-container">
                            <image class="remove_field" src="../img/close.png" alt="削除">
                        </div>
                        <div class="each-field field">
                            <label for="received_from"><?php checkLang('Clients - Helpers', '取引先・スタッフ名など');?></label>
                            <input type="text" name="received_from[]" id="received_from" value="<?php echo $_SESSION['received_from'][$i];?>" required>
                        </div>

                        <div class="each-field field">
                            <label for="total_received"><?php checkLang('Amount of Money Received', '入金額');?></label>
                            <input type="number" name="total_received[]" id="total_received" value="<?php echo $_SESSION['total_received'][$i];?>" required>
                        </div>

                        <div class="each-field field">
                            <label for="content_received"><?php checkLang('Items & Services Sold', '入金の内容');?></label>
                            <input type="text" name="content_received[]" id="content_received" value="<?php echo $_SESSION['content_received'][$i];?>" required>            
                        </div>
                    </div>
                <?php endfor;?>
                <?php else :?>
                    <div class="each-received">
                        <div class="each-field field">
                            <label for="received_from"><?php checkLang('Clients - Helpers', '取引先・スタッフ名など');?></label>
                            <input type="text" name="received_from[]" id="received_from" placeholder="<?php checkLang('Leave it Blank if No Transaction', '取引なしは入力しない');?>">
                        </div>

                        <div class="each-field field">
                            <label for="total_received"><?php checkLang('Amount of Money Received', '入金額');?></label>
                            <input type="number" name="total_received[]" id="total_received" placeholder="<?php checkLang('Leave it Blank if No Transaction', '取引なしは入力しない');?>">
                        </div>

                        <div class="each-field field">
                            <label for="content_received"><?php checkLang('Items & Services Sold', '入金の内容');?></label>
                            <input type="text" name="content_received[]" id="content_received" placeholder="<?php checkLang('Leave it Blank if No Transaction', '取引なしは入力しない');?>">            
                        </div>
                    </div>
                <?php endif;?>
            </div>

            <div class="add-container">
                <img class="add_button" src="../img/plus.png" alt="<?php checkLang('Add', '追加');?>">
            </div>
            <div class="back_next_container">
                <input type="submit" name="next" value="<?php checkLang('Next', '次へ');?>" class="next_button"/>
                <?php if(isset($_SESSION['went_to_confirmation'])):?>
                <input type="submit" name="back" value="<?php checkLang('Back', '戻る');?>" class="back_button"/>
                <?php else:?>
                <a href="q_1_3.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
                <?php endif ;?>
            </div>
            <?php require 'back_to_top.php';?>
        </form>
    </div>

    <?php require 'back_to_top_modal.php';?>
    

    <script>
        $(document).ready(function(){
            var add_button = $(".add_button");
            var wrapper = $(".input_fields_wrapper");

            var lang = '<?php echo $lang; ?>';
            if(lang == 'eng'){
                var label_1 = 'Clients - Helpers';
                var label_2 = 'Amount of Money Received';
                var label_3 = 'What the Payment was For';
            } else {
                var label_1 = '取引先・スタッフなど';
                var label_2 = '入金額';
                var label_3 = '入金内容';
            }

            $(add_button).click(function(){
                $(wrapper).append(
                    '<div class="each-received">' +
                    '<div class="icon-container">' +
                    '<image class="remove_field" src="../img/close.png" alt="">' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="received_from">' + label_1 + '</label>' +
                    '<input type="text" name="received_from[]" id="received_from" required>' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="total_received">' + label_2 + '</label>' +
                    '<input type="number" name="total_received[]" id="total_received" required>' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="content_received">' + label_3 + '</label>' +
                    '<input type="text" name="content_received[]" id="content_received" required>' +
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