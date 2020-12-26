<?php
    //Logo created using Logo Factory
    ini_set('display_errors', TRUE);
    session_start();
    $token = bin2hex(random_bytes(16));
    $_SESSION["loginToken"] = $token;

    require_once(dirname(__FILE__) . "/php/components.php");

    $errormsg = '<p class="loginError text-danger">ログインできませんでした。</p>';
    $regmsg = '<p class="loginError text-success">登録完了しました。ログインしてください。</p>';

?>
<?php echo getHeader();?>
<div id="wrapper">
<div class="container">
  <img src="images/logo.png" id="logo">
    <div class="row">
        <form method="POST" action="databases/auth/verify.php" id="loginForm" class="col-md-6 col-xs-12">
            <h2 class="text-center">ログイン</h2>
            <?php
                	if(isset($_GET["error"]) &&  $_GET["error"] == "true")
                    echo $errormsg;

                  if(isset($_GET["registration"]) &&  $_GET["registration"] == "success")
                    echo $regmsg;
            ?>
            ユーザー名:<br/><input type="text" class="form-control" name="username" placeholder=""/><br/>
            パスワード:<br/><input type="password" class="form-control" name="password" placeholder=""/>
            <input type="hidden" name="token" value="<?php echo $token; ?>"/>
            <br/>
            <input type="submit" class="btn btn-primary" value="ログイン"/>
        </form>
        <br/>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
