<?php
if(isset($_POST['back_to_top'])){

foreach($_SESSION as $key => $val){
    if ($key !== 'logged_in' && $key !== 'branch'){
        unset($_SESSION[$key]);
    }
}

header('Location: ../index.php');
}
?>