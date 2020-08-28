<?php
    session_start();

    if(!$_SESSION['logged_in'] == 'logged_in') {
        header('Location: ../index.php');
    }

    require '../lang.php';

    if(isset($_POST['next']) || isset($_POST['back'])) {

            $_SESSION['next_day_change'] = $_POST['next_day_change'];
            $_SESSION['jisen_total'] = $_POST['jisen_total'];
            $_SESSION['next_day_deposit'] = $_POST['next_day_deposit'];
            if($_POST['next']){
                header('Location: q_9_11.php');
            } else if($_POST['back']){
                header('Location: q_5.php');
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
        <div class="each-field field">
                <label for="jisen_total">６. <?php checkLang('Total Balance', '実残合計');?></label>
                <input type="number" name="jisen_total" id="jisen_total"
                value="<?php echo $_SESSION['jisen_total']; ?>" required>
            </div>

            <div class="each-field field">
                <label for="next_day_change">7. <?php checkLang('Change for the Next Day', '翌日のつり銭額を入力してください');?></label>
                <input type="number" name="next_day_change" id="next_day_change" 
                value="<?php echo $_SESSION['next_day_change']; ?>" required>
            </div>

            <div class="each-field field">
                <label for="next_day_deposit">8 . <?php checkLang('Deposit for the Next Day', '翌日預入の金額を入力してください(0円の場合も記入)。');?></label>
                <input type="number" name="next_day_deposit" id="next_day_deposit" 
                value="<?php echo $_SESSION['next_day_deposit']; ?>" required>
            </div>

            <div class="back_next_container">
                <input type="submit" name="next" value="<?php checkLang('Next', '次へ');?>" class="next_button"/>
                <?php if(isset($_SESSION['went_to_confirmation'])):?>
                <input type="submit" name="back" value="<?php checkLang('Back', '戻る');?>" class="back_button"/>
                <?php else:?>
                <a href="q_5.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
                <?php endif ;?>
            </div>
            <?php require 'back_to_top.php';?>
        </form>
    </div>

    <?php require 'back_to_top_modal.php';?>
</body>
</html>