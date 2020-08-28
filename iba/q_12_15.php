<?php
    session_start();

    if(!$_SESSION['logged_in'] == 'logged_in') {
        header('Location: ../index.php');
    }

    require '../lang.php';

    if(isset($_POST['next']) || isset($_POST['back'])) {
        if($_POST['dc_how_much'][0] === '' || is_null($_POST['dc_how_much'])) {
            $_SESSION['dc_how_much'] = null;
        } else {
            $_SESSION['dc_how_much'] = $_POST['dc_how_much'];
        }

        if($_POST['jcb_how_much'][0] === '' ||  is_null($_POST['jcb_how_much'])) {
            $_SESSION['jcb_how_much'] = null;
        } else {
            $_SESSION['jcb_how_much'] = $_POST['jcb_how_much'];
        }
        
        $_SESSION['paypay_count'] = $_POST['paypay_count'];
        $_SESSION['paypay_total'] = $_POST['paypay_total'];
        $_SESSION['nanaco_count'] = $_POST['nanaco_count'];
        $_SESSION['nanaco_total'] = $_POST['nanaco_total'];
        $_SESSION['edy_count'] = $_POST['edy_count'];
        $_SESSION['edy_total'] = $_POST['edy_total'];
        $_SESSION['transport_ic_count'] = $_POST['transport_ic_count'];
        $_SESSION['transport_ic_total'] = $_POST['transport_ic_total'];
        $_SESSION['quick_pay_count'] = $_POST['quick_pay_count'];
        $_SESSION['quick_pay_total'] = $_POST['quick_pay_total'];
        $_SESSION['waon_count'] = $_POST['waon_count'];
        $_SESSION['waon_total'] = $_POST['waon_total'];
        if($_POST['other_e_money_name']) {
            $_SESSION['other_e_money_name'] = $_POST['other_e_money_name'];
            $_SESSION['other_e_money_count'] = $_POST['other_e_money_count'];
            $_SESSION['other_e_money_amount'] = $_POST['other_e_money_amount'];
        } else {
            $_SESSION['other_e_money_name'] = array();
            $_SESSION['other_e_money_count'] = array();
            $_SESSION['other_e_money_amount'] = array();
        }
        if($_POST['next']){
            header('Location: q_16.php');
        } else if($_POST['back']){
            header('Location: q_9_11.php');
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
            <div class="dc_container each-card">
                <h2 class="ui header">12. <?php checkLang('DC', 'DCカード金額（1取引ごと）');?></h2>

                <?php if (isset($_SESSION['dc_how_much'])):?>
                <?php for($i = 0; $i < count($_SESSION['dc_how_much']); $i++):?>
                <div class="field">
                    <div class="icon-container">
                        <img class="remove_dc" src="../img/close.png" alt="">
                    </div>
                    <label for="dc_how_much"><?php checkLang('Payment', '金額');?></label>
                    <input type="number" name="dc_how_much[]" id="dc_how_much" 
                    value="<?php echo $_SESSION['dc_how_much'][$i];?>" required>
                </div>
                <?php endfor ;?>
                <?php else :?>
                    <div class="field">
                    <label for="dc_how_much"><?php checkLang('Payment', '金額');?></label>
                    <input type="number" name="dc_how_much[]" id="dc_how_much" 
                    value="<?php echo $_SESSION['dc_how_much'][$i];?>" placeholder="<?php checkLang('Blank If No Transaction', '取引なしは入力しない');?>">
                </div>
                <?php endif;?>
            </div>
            <div class="add-container">
                <img class="add_button add_dc" src="../img/plus.png" alt="">
            </div>

            <div class="jcb_container each-card">
                <h2 class="ui header">13. <?php checkLang('JCB', 'JCBカード金額（1取引ごと）');?></h2>

                <?php if(isset($_SESSION['jcb_how_much'])):?>
                <?php for($i = 0; $i < count($_SESSION['jcb_how_much']); $i++):?>
                <div class="field">
                    <div class="icon-container">
                        <img class="remove_jcb" src="../img/close.png" alt="">
                    </div>
                    <label for="jcb_how_much"><?php checkLang('Payment', '金額');?></label>
                    <input type="number" name="jcb_how_much[]" id="jcb_how_much"
                    value="<?php echo $_SESSION['jcb_how_much'][$i];?>" required>
                </div>
                <?php endfor ;?>
                <?php else :?>
                    <div class="field">
                    <label for="jcb_how_much"><?php checkLang('Payment', '金額');?></label>
                    <input type="number" name="jcb_how_much[]" id="jcb_how_much"
                    value="<?php echo $_SESSION['jcb_how_much'][$i];?>" placeholder="<?php checkLang('Blank If No Transaction', '取引なしは入力しない');?>">
                </div>
                <?php endif;?>
            </div>
            <div class="add-container">
            <img class="add_button add_jcb" src="../img/plus.png" alt="">
            </div>

            <div class="paypay_container each-card">
                <h2 class="ui header">14. <?php checkLang('PayPay', 'PayPay金額');?></h2>

                <div class="field">
                    <label for="paypay_count"><?php checkLang('How Many Transactions', '件数');?></label>
                    <input type="number" name="paypay_count" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" 
                    value="<?php echo $_SESSION['paypay_count'];?>" id="paypay_count" required>
                </div>
                <div class="field">
                    <label for="paypay_total"><?php checkLang('Total Payment', '総額');?></label>
                    <input type="number" name="paypay_total" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>"
                    value="<?php echo $_SESSION['paypay_total'];?>" id="paypay_total" required>
                </div>
            </div>

            <div class="others_container each-card">
                <h2 class="ui header">15. <?php checkLang('Other EC CARD', 'その他');?></h2>

                <div class="field">
                    <label for="nanaco_count"><?php checkLang('How Many Nanaco Transactions', 'nanaco 件数');?></label>
                    <input type="number" name="nanaco_count" value="<?php echo $_SESSION['nanaco_count'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" id="nanaco_count" required>
                </div>
                <div class="field">
                    <label for="nanaco_total"><?php checkLang('Nanaco Total Payment', 'nanaco 金額');?></label>
                    <input type="number" name="nanaco_total" value="<?php echo $_SESSION['nanaco_total'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" id="nanaco_total" required>
                </div>


                <div class="field">
                    <label for="edy_count"><?php checkLang('How Many Edy Transactions', 'Edy 件数');?></label>
                    <input type="number" name="edy_count" value="<?php echo $_SESSION['edy_count'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" id="edy_count" required>
                </div>
                <div class="field">
                    <label for="edy_total"><?php checkLang('Edy Total Payment', 'Edy 金額');?></label>
                    <input type="number" name="edy_total" value="<?php echo $_SESSION['edy_total'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" id="edy_total" required>
                </div>
                

                <div class="field">
                    <label for="transport_ic_count"><?php checkLang('How Many Transport IC Transactions', '交通IC 件数');?></label>
                    <input type="number" name="transport_ic_count" value="<?php echo $_SESSION['transport_ic_count'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" required>
                </div>
                <div class="field">
                    <label for="transport_ic_total"><?php checkLang('Transport IC Total Payment', '交通IC 金額');?></label>
                    <input type="number" name="transport_ic_total" value="<?php echo $_SESSION['transport_ic_total'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" required>
                </div>

                <div class="field">
                    <label for="quick_pay_count"><?php checkLang('How Many Quick Pay Transactions', 'Quick Pay 件数');?></label>
                    <input type="number" name="quick_pay_count" value="<?php echo $_SESSION['quick_pay_count'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" required>
                </div>
                <div class="field">
                    <label for="quick_pay_total"><?php checkLang('Quick Pay Total Payment', 'Quick Pay 金額');?></label>
                    <input type="number" name="quick_pay_total" value="<?php echo $_SESSION['quick_pay_total'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" required>
                </div>

                <div class="field">
                    <label for="waon_count"><?php checkLang('How Many WAON Transactions', 'WAON 件数');?></label>
                    <input type="number" name="waon_count" value="<?php echo $_SESSION['waon_count'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" required>
                </div>
                <div class="field">
                    <label for="waon_total"><?php checkLang('WAON Total Payment', 'WAON 金額');?></label>
                    <input type="number" name="waon_total" value="<?php echo $_SESSION['waon_total'];?>" placeholder="<?php checkLang('0 If No Transaction', '取引なしは0');?>" required>
                </div>

                <?php if(isset($_SESSION['other_e_money_name'])) :?>
                    <?php for($i = 0; $i < count($_SESSION['other_e_money_name']); $i++):?>
                        <div>
                            <div class="field">
                                <label for="other_e_money_name" id="label-with-remove-button">
                                    <span><?php checkLang('E Money Name', '電子マネー名');?></span>
                                    <image class="remove_field" src="../img/close.png" alt="削除">
                                </label>
                                <input type="text" id="other_e_money_name" name="other_e_money_name[]" value="<?php echo $_SESSION['other_e_money_name'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="other_e_money_count"><?php checkLang('How Many', '枚数');?></label>
                                <input type="number" id="other_e_money_count" name="other_e_money_count[]" value="<?php echo $_SESSION['other_e_money_count'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="other_e_money_amount"><?php checkLang('Total Payment', '金額');?></label>
                                <input type="number" id="other_e_money_amount" name="other_e_money_amount[]" value="<?php echo $_SESSION['other_e_money_amount'][$i];?>" required>
                            </div>
                        </div>
                    <?php endfor ;?>
                <?php endif ;?>

            </div>

            <div class="add-container">
                <img class="add_button" src="../img/plus.png" alt="">
            </div>

            <div class="back_next_container">
                <input type="submit" name="next" value="<?php checkLang('Next', '次へ');?>" class="next_button"/>
                <?php if(isset($_SESSION['went_to_confirmation'])):?>
                <input type="submit" name="back" value="<?php checkLang('Back', '戻る');?>" class="back_button"/>
                <?php else:?>
                <a href="q_9_11.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
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
                var payment = 'Payment';
                var noTransaction = '0 If No Transaction';
                var eMoney = 'E Money Name';
                var count = 'How Many';
                var total = 'Total Payment';
            } else {
                var payment = '金額';
                var noTransaction = '取引なしは0';
                var eMoney = '電子マネー名';
                var count = '枚数';
                var total = '金額';
            }


            /*DC追加*/
            var add_dc = $(".add_dc");
            var wrapper_dc = $(".dc_container");

            $(add_dc).click(function(e){
                e.preventDefault();
                $(wrapper_dc).append('<div class="field">' +
                    '<div class="icon-container">' +
                    '<img class="remove_dc" src="../img/close.png" alt="削除">' +
                    '</div>' +
                    '<label for="dc_how_much">' + payment + '</label>' +
                    '<input type="number" name="dc_how_much[]" id="dc_how_much" placeholder="' + noTransaction + '" required>' +
                    '</div>');
            });

            $(wrapper_dc).on('click', '.remove_dc', function(e){
                e.preventDefault();
                $(this).parent('div').parent('div').remove();
            });

            /*JCB追加*/
            var add_jcb = $(".add_jcb");
            var wrapper_jcb = $(".jcb_container");

            $(add_jcb).click(function(e){
                e.preventDefault();
                $(wrapper_jcb).append(
                    '<div class="field">' +
                    '<div class="icon-container">' +
                    '<img class="remove_jcb" src="../img/close.png" alt="削除">' +
                    '</div>' +
                    '<label for="jcb_how_much">' + payment + '</label>' +
                    '<input type="number" name="jcb_how_much[]" id="jcb_how_much" placeholder="' + noTransaction + '" required>' +
                    '</div>'
                );
            });

            $(wrapper_jcb).on('click', '.remove_jcb', function(e){
                e.preventDefault();
                $(this).parent('div').parent('div').remove();
            });

            /*電子マネー追加*/
            var add_button = $(".add_button");
            var wrapper = $(".others_container");

            $(add_button).click(function(){
                $(wrapper).append(
                    `<div>
                        <div class="field">
                            <label for="other_e_money_name" id="label-with-remove-button">
                                <span>${eMoney}</span>
                                <image class="remove_field" src="../img/close.png" alt="">
                            </label>
                            <input type="text" id="other_e_money_name" name="other_e_money_name[]" required>
                        </div>
                        <div class="field">
                            <label for="other_e_money_count">${count}</label>
                            <input type="number" id="other_e_money_count" name="other_e_money_count[]" required>
                        </div>
                        <div class="field">
                            <label for="other_e_money_amount">${total}</label>
                            <input type="number" id="other_e_money_amount" name="other_e_money_amount[]" required>
                        </div>
                    </div>`
                );
            });

            $(wrapper).on('click', '.remove_field', function(e){
                e.preventDefault();
                $(this).parent('label').parent('div').parent('div').remove();
            });

        });
    </script>
</body>
</html>