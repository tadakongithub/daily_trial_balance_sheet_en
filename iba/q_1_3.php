<?php
    session_start();
    require '../lang.php';

    if(!$_SESSION['logged_in'] == 'logged_in') {
        header('Location: ../index.php');
    }

    if(isset($_POST['next']) || isset($_POST['back'])) {
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['change'] = $_POST['change'];
        $_SESSION['earning'] = $_POST['earning'];
        if($_POST['next']){
            header('Location: q_4.php');
        } else if($_POST['back']){
            header('Location: date.php');
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
                <label for="name">1. <?php checkLang('Name', '名前');?></label>
                <input type="text" name="name" id="name" value="<?php if(isset($_SESSION['name'])) {echo $_SESSION['name'];};?>" required>
            </div>
            
            <div class="each-field field">
                <label for="change">2. <?php checkLang('Change', '釣り銭金額');?></label>
                <input type="number" name="change" id="change" value="<?php echo $_SESSION['change'];?>" required>
            </div>

            <div class="each-field field">
                <label for="earning">3. <?php checkLang('Cash Sale', '現金売り上げ');?></label>
                <input type="number" name="earning" id="earning" value="<?php echo $_SESSION['earning'];?>" required>
            </div>

            <div class="back_next_container">
                <input type="submit" name="next" value="<?php checkLang('Next', '次へ');?>" class="next_button"/>
                <?php if(isset($_SESSION['went_to_confirmation'])):?>
                <input type="submit" name="back" value="<?php checkLang('Back', '戻る');?>" class="back_button"/>
                <?php else:?>
                <a href="date.php" class="back_button"><?php checkLang('Back', '戻る');?></a>
                <?php endif ;?>
            </div>
            <?php require 'back_to_top.php';?>
        </form>
    </div>



    <?php require 'back_to_top_modal.php';?>
</body>
</html>