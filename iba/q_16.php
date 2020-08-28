<?php

session_start();

if($_SESSION['logged_in'] !== 'logged_in') {
    header('Location: ../index.php');
}
require '../lang.php';

if(isset($_POST['next'])) {
    if ( ($_POST['client_name'][0] === '' || $_POST['urikake_total'][0] === '') || is_null($_POST['client_name']) ) {
        $_SESSION['client_name'] = null;
        $_SESSION['urikake_total'] = null;
        header('Location: confirmation.php');
    } else {
        $_SESSION['client_name'] = $_POST['client_name'];
        $_SESSION['urikake_total'] = $_POST['urikake_total'];
        header('Location: confirmation.php');
    }
}

if(isset($_POST['back'])) {
    if ( ($_POST['client_name'][0] === '' || $_POST['urikake_total'][0] === '') || is_null($_POST['client_name']) ) {
        $_SESSION['client_name'] = null;
        $_SESSION['urikake_total'] = null;
        header('Location: q_12_15.php');
    } else {
        $_SESSION['client_name'] = $_POST['client_name'];
        $_SESSION['urikake_total'] = $_POST['urikake_total'];
        header('Location: q_12_15.php');
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
        <form action="" method="post" class="ui form">
            <h2 class="ui header">16. <?php checkLang('Accounts Receivable-Trade', '売掛金');?></h2>

            <div class="client-container">
            <?php if(isset($_SESSION['client_name'])):?>
                <?php for($i = 0; $i < count($_SESSION['client_name']); $i++): ?>
                <div class="each-client">
                    <div class="icon-container">
                        <img class="remove_field" src="../img/close.png" alt="">
                    </div>
                    <div class="each-field field">
                        <label for="client_name"><?php checkLang('Client', 'お客様');?></label>
                        <input type="text" name="client_name[]" id="client_name"
                        value="<?php echo $_SESSION['client_name'][$i];?>" required>
                    </div>
                    <div class="each-field field">
                        <label for="urikake_total"><?php checkLang('Payment', '金額');?></label>
                        <input type="number" name="urikake_total[]" id="urikake_total"
                        value="<?php echo $_SESSION['urikake_total'][$i];?>" required>
                    </div>
                </div>
                <?php endfor ;?>
                <?php else :?>
                    <div class="each-client">
                    <div class="each-field field">
                        <label for="client_name"><?php checkLang('Client', 'お客様');?></label>
                        <input type="text" name="client_name[]" id="client_name"
                        placeholder="<?php checkLang('Blank If No Transaction', '取引なしは入力しない');?>">
                    </div>
                    <div class="each-field field">
                        <label for="urikake_total"><?php checkLang('Payment', '金額');?></label>
                        <input type="number" name="urikake_total[]" id="urikake_total"
                        placeholder="<?php checkLang('Blank If No Transaction', '取引なしは入力しない');?>">
                    </div>
                </div>
                <?php endif;?>
            </div>
            

            <div class="add-container">
                <img class="add_button" src="../img/plus.png" alt="">
            </div>
            <!-- <input type="hidden" name="q_16" value="q_16"> -->
            <div class="back_next_container">
                <input type="submit" name="next" value="<?php checkLang('To Confirm', '確認画面へ');?>" class="next_button"/>
                <?php if(isset($_SESSION['went_to_confirmation'])):?>
                <input type="submit" name="back" value="<?php checkLang('Back', '戻る');?>" class="back_button"/>
                <?php else:?>
                <a href="q_12_15.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
                <?php endif ;?>
            </div>
            <?php require 'back_to_top.php';?>
        </form>
    </div> 

    <?php require 'back_to_top_modal.php';?>

        <script>
            $(document).ready(function(){

                /*指定言語で表示変える*/
                var lang = '<?php echo $lang; ?>';
                if(lang == 'eng'){
                    var label_1 = 'Client';
                    var label_2 = 'Payment';
                } else {
                    var label_1 = 'お客様';
                    var label_2 = '金額';
                }
                var add = $('.add_button');
                var wrapper = $('.client-container');

                $(add).click(function(e){
                    e.preventDefault();
                    $(wrapper).append('<div class="each-client">' +
                    '<div class="icon-container">' +
                    '<img class="remove_field" src="../img/close.png" alt="">' +
                    '</div>' +
                    '<div class="each-field field">' +
                    '<label for="client_name">' + label_1 + '</label>' +
                    '<input type="text" name="client_name[]" id="client_name" required>' +
                    '</div>'+
                    '<div class="each-field field">'+
                    '<label for="urikake_total">' + label_2 + '</label>' +
                    '<input type="number" name="urikake_total[]" id="urikake_total" required>' +
                    '</div>' +
                    '</div>');
                });

                $(wrapper).on('click', '.remove_field', function(e){
                    e.preventDefault();
                    $(this).parent('div').parent('div').remove();
                });

            });
        </script>
    </body>
</html>