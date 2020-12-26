<?php
    ini_set('display_errors', TRUE);
    require_once("databases/auth/auth.php");
    $token = bin2hex(random_bytes(16));
    $_SESSION["token"] = $token;

    require_once("php/components.php");
    $errormsg = "";

    if(isset($_GET["error"])){
        switch($_GET["error"]){
            case 1:
                $errormsg = '<p class="text-center text-danger">現在のパスワードが違います。</p>';
            break;
            case 2:
                $errormsg = '<p class="text-center text-danger">新しいパスワードが一致しません。</p>';
            break;
        }
    }


?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php echo getNavbar() ?>
<div class="container">
    <div class="row">
        <div class="main col-md-12 col-xs-12">
            <br/>
            <div class="card border-info">
                <div class="card-header">
                    <h2 class="card-title text-info">パスワードの変更</h2>
                </div>
                <div class="card-body">
                    <?php echo $errormsg ?>
                    <form method="POST" action="databases/account/updatePassword.php" class="accountForm">
                        <table class="table">
                            <tr><td>現在のパスワード:</td><td><input type="password" class="form-control" name="oldPassword"/></td></tr>
                            <tr><td>新しいパスワード:</td><td><input type="password" class="form-control" name="password" /></td></tr>
                            <tr><td>新しいパスワード (再入力):</td><td><input type="password" class="form-control" name="password2" /></td></tr>
                        </table>
                        <input type="hidden" value="<?php echo $token ?>" name="token"/>
                        <div class="d-flex">
                            <input type="submit" class="btn btn-primary" value="変更する" />
                            <input type="button" onclick="window.location.replace('account.php')" class="btn btn-secondary" value="戻る" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
