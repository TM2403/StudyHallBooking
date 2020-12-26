<?php
    ini_set('display_errors', TRUE);
    require_once("databases/auth/auth.php");
    require_once("php/components.php");

    $username = $_SESSION["username"];
    $role = $_SESSION["role"];

?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php echo getNavbar() ?>
<div class="container">
    <div class="row">
        <div class="main col-md-12 col-xs-12">
            <br/>
            <div class="card border-secondary">
                <div class="card-header">
                    <h2 class="card-title text-secondary">アカウント</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr><td>ユーザー名: </td><td><?php echo $username ?></td></tr>
                        <tr><td>役割: </td><td><?php echo getStringRole($role)?></td></tr>
                    </table>
                    <div class="d-flex">
                        <input type="button" onclick="javascript:window.location.replace('changePassword.php')" class="btn btn-warning m-auto" value="パスワード変更" />
                  </div>
                </div>
            </div>
            <br/>
        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
