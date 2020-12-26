<?php
    ini_set('display_errors', TRUE);
    session_start();
    require_once(dirname(__FILE__) . "/databases/seats/seatsInfo.php");
    require_once("php/components.php");

    $token = bin2hex(random_bytes(16));
    $_SESSION["token"] = $token;

    $type = 0;
    $legends = '使用不可の席にチェックを入れてください。';

?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php echo getNavbar();?>

<div class="container">
    <div class="row">
        <div class="main col-md-12 col-xs-12">
            <h1 class="text-dark">自習室の空席状況</h1>
            <h4 class="text-dark"><br/>
            <?php echo $legends; ?>
            </h4>
            <br/>
            <form method="POST" action="databases/seats/seatControl.php">
            <input type="submit" class="btn btn-primary" value="変更する" style="width: 100px"/>
            <input type="button" onclick="window.location.href = 'index.php'" class="btn btn-secondary" style="width: 100px" value="戻る" />
            <br/><br/>
                <?php
                  echo displaySeatsControl($type);
                ?>
                <input type="hidden" value="<?php echo $token ?>" name="token"/>
              </form>
            </div>
            <br/>
        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
