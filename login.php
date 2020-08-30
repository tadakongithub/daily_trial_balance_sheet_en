<?php
    session_start();

    require 'db.php';
    require 'lang.php';

    if(isset($_POST['login'])) {
        if(empty($_POST['branch_name']) || empty($_POST['password'])) {
            $message = 'All fields are required';
        }  else {
            $query = 'SELECT * FROM branch_list WHERE name = :name';
            $statement = $myPDO->prepare($query);
            $statement->execute(array(
                'name' => $_POST['branch_name']
            ));
            $branch = $statement->fetch();
            if($branch && password_verify($_POST['password'], $branch['password'])) {
                $_SESSION['branch'] = $_POST['branch_name'];
                $_SESSION['logged_in'] = 'logged_in';
                header('Location: index.php');
            } else {
                checkLang('Branch and password did not match', '店舗名とパスワードが一致しませんでした');
            }
        }
    }

?>

<html>
<head>
    <?php require 'head.php'; ?>
</head>
<body  class="flex-body">
<div  class="home-container">
<?php
    if(isset($message)) {
        echo '<p>' . $message . '</p>';
    }
?>
    <h1 class="ui header"><?php checkLang('Okasato Inc.', 'おかさと庵');?></h1>
        <form action="" method="post" class="ui form">
            <div class="field">
                <label for="branch_name"><?php checkLang('Branch', '店舗');?></label>
                <select name="branch_name" id="branch_name" class="ui dropdown" required>
                <?php foreach($myPDO->query('SELECT * FROM branch_list') as $row):?>
                    <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                <?php endforeach ;?>
                </select>
            </div>
            <div class="field">
            <label for="password"><?php checkLang('Password', 'パスワード');?></label>
                <input type="text" name="password" id="password" required>
            </div>
            <input type="hidden" name="login" value="login">

            <button type="submit" class="submit-btn"><?php checkLang('Log In', 'ログイン');?></button>
           
        </form>
</div>

<!-- modal -->
<div class="ui basic modal">
  <!-- <div class="ui icon header">
    <i class="archive icon"></i>
    Archive Old Messages
  </div> -->
  <div class="content">
    <p>This app is a demo app showcasing my work. To see how this app would run, log in with the following info:</p>
    <ul>
        <li>Oakland Branch: 0000</li>
        <li>Admin: 0000</li>
    </ul>
  </div>
  <div class="actions">
    <!-- <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      No
    </div> -->
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      OK
    </div>
  </div>
</div>

<script>
    $(window).on('load', function() {
        $('.ui.basic.modal').modal('show');
    });
</script>
<script src="semantic-ui-pulldown.js"></script>
</body>
</html>


