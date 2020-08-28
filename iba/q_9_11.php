<?php
    session_start();

    if(!$_SESSION['logged_in'] == 'logged_in') {
        header('Location: ../index.php');
    }

    require '../lang.php';

    if(isset($_POST['next']) || isset($_POST['back'])) {
        $_SESSION['prem_count'] = $_POST['prem_count'];
        $_SESSION['prem_total'] = $_POST['prem_total'];
        $_SESSION['for_selling_count'] = $_POST['for_selling_count'];
        $_SESSION['for_selling_total'] = $_POST['for_selling_total'];
        $_SESSION['thousand_count'] = $_POST['thousand_count'];
        $_SESSION['thousand_total'] = 1000 * $_POST['thousand_count'];
        $_SESSION['five_count'] = $_POST['five_count'];
        $_SESSION['five_total'] = 500 * $_POST['five_count'];
        $_SESSION['two_count'] = $_POST['two_count'];
        $_SESSION['two_total'] = 200 * $_POST['two_count'];
        if ($_POST['other_name'][0] !== '' && $_POST['other_count'][0] !== '' && $_POST['other_how_much'] !== '') {
            $_SESSION['other_name'] = $_POST['other_name'];
            $_SESSION['other_count'] = $_POST['other_count'];
            $_SESSION['other_how_much'] = $_POST['other_how_much'];
        }
        if($_POST['next']){
            header('Location: q_12_15.php');
        } else if($_POST['back']){
            header('Location: q_6_7_8.php');
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
        
            <div class="each-ticket">
                <h2 class="ui header">9. <?php checkLang('Premiem Meal Tickets', 'プレミアム食事券の枚数と金額を入力してください');?></h2>

                <div class="field">
                    <label for="prem_count"><?php checkLang('How Many', '枚数');?></label>
                    <input type="number" name="prem_count" id="prem_count"
                    value="<?php echo $_SESSION['prem_count'];?>" placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>
                <div class="field">
                    <label for="prem_total"><?php checkLang('Price', '金額');?></label>
                    <input type="number" name="prem_total" id="prem_total"
                    value="<?php echo $_SESSION['prem_total'];?>" placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>
            </div>

            <div class="each-ticket">
                <h2 class="ui header">10. <?php checkLang('Meal Tickets for Sale', '販売用食事券の枚数と金額を入力してください');?></h2>

                <div class="field">
                    <label for="for_selling_count"><?php checkLang('How Many', '枚数');?></label>
                    <input type="number" name="for_selling_count" id="for_selling_count"
                    value="<?php echo $_SESSION['for_selling_count'];?>" placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>
                <div class="field">
                    <label for="for_selling_total"><?php checkLang('Price', '金額');?></label>
                    <input type="number" name="for_selling_total" id="for_selling_total"
                    value="<?php echo $_SESSION['for_selling_total'];?>" placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>
            </div>

            <div class="service_wrapper each-ticket">
                <h2 class="ui header">11. <?php checkLang('Service Tickets', 'サービス用回収の種類、枚数、金額を入力してください。');?></h2>

                <div class="field">
                    <label for="thousand_count"><?php checkLang('How Many $10 tickets', '1000円券枚数');?></label>
                    <input type="number" name="thousand_count" id="thousand_count" 
                    value="<?php echo $_SESSION['thousand_count'];?>" placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>
                   
                <div class="field">
                    <label for="five_count"><?php checkLang('How Many $5 tickets', '500円券枚数');?></label>
                    <input type="number" name="five_count" id="five_count" 
                    value="<?php echo $_SESSION['five_count'];?>"placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>
                   
                <div class="field">
                    <label for="two_count"><?php checkLang('How Many $2 tickets', '200円券枚数');?></label>
                    <input type="number" name="two_count" id="two_count"
                    value="<?php echo $_SESSION['two_count'];?>" placeholder="<?php checkLang('0 if No Transaction', '取引なしは0');?>" required>
                </div>   
                
                
            </div>

            <div class="other_service_wrapper">
                <h2 class="ui header"><?php checkLang('Other Tickets', 'その他');?></h2>

                <?php if(isset($_SESSION['other_name'])):?>
                    <?php for($i = 0; $i < count($_SESSION['other_name']); $i++):?>
                        <div class="field">
                            <div class="icon-container">
                                <image class="remove_field" src="../img/close.png" alt="">
                            </div>
                            <label for="other_name"><?php checkLang('Ticket Name', '項目名');?></label>
                            <input type="text" name="other_name[]" id="other_name"
                            value="<?php echo $_SESSION['other_name'][$i];?>" required>
                            <label for="other_count"><?php checkLang('How Many', '枚数');?></label>
                            <input type="number" name="other_count[]" id="other_count"
                            value="<?php echo $_SESSION['other_count'][$i];?>" required>
                            <label for="other_how_much"><?php checkLang('Price', '金額');?></label>
                            <input type="number" name="other_how_much[]" id="other_how_much"
                            value="<?php echo $_SESSION['other_how_much'][$i];?>" required>
                        </div> 
                    <?php endfor;?>
                <?php else :?>
                    <div class="field">
                        <label for="other_name"><?php checkLang('Ticket Name', '項目名');?></label>
                        <input type="text" name="other_name[]" id="other_name"
                        placeholder="<?php checkLang('Blank if No Transaction', '取引なしは入力しない');?>">
                        <label for="other_count"><?php checkLang('How Many', '枚数');?></label>
                        <input type="number" name="other_count[]" id="other_count"
                        placeholder="<?php checkLang('Blank if No Transaction', '取引なしは入力しない');?>">
                        <label for="other_how_much"><?php checkLang('Price', '金額');?></label>
                        <input type="number" name="other_how_much[]" id="other_how_much"
                        placeholder="<?php checkLang('Blank if No Transaction', '取引なしは入力しない');?>">
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
                <a href="q_6_7_8.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
                <?php endif ;?>
            </div>
            <?php require 'back_to_top.php';?>
        </form>
    </div>

    <?php require 'back_to_top_modal.php';?>

    <script>
        $(document).ready(function(){
            var add_button = $(".add_button");
            var wrapper = $(".other_service_wrapper");

            var lang = '<?php echo $lang; ?>';
            if(lang == 'eng'){
                var label_1 = 'Ticket Name';
                var label_2 = 'How Many';
                var label_3 = 'Price';
            } else {
                var label_1 = '項目名';
                var label_2 = '枚数';
                var label_3 = '金額';
            }

            $(add_button).click(function(){
                $(wrapper).append(
                    '<div class="field">' +
                        '<div class="icon-container">' +
                        '<image class="remove_field" src="../img/close.png" alt="">' +
                        '</div>' +
                        '<label for="other_name">' + label_1 + '</label>' +
                        '<input type="text" name="other_name[]" id="other_name" required>' +
                        '<label for="other_count">' + label_2 + '</label>' +
                        '<input type="number" name="other_count[]" id="other_count" required>' +
                        '<label for="other_how_much">' + label_3 + '</label>' +
                        '<input type="number" name="other_how_much[]" id="other_how_much" required>' +
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