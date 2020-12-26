<?php
    ini_set('display_errors', TRUE);
    require_once("databases/auth/auth.php");
    require_once(dirname(__FILE__) . "/databases/seats/seatsInfo.php");
    require_once("php/components.php");

    $type = 0;

    if(isset($_SESSION["role"]))
        $type = $_SESSION["role"];

    if(isset($_SESSION["seatNumber"]))
        $_SESSION["seatNumber"] = "";

    if(isset($_SESSION["studentID"]))
        $_SESSION["studentID"] = "";

    if(isset($_SESSION["internetUse"]))
        $_SESSION["internetUse"] = -1;

    $msghtml = "";
    if(isset($_SESSION["seatReservaton"])){
      if($_SESSION["seatReservaton"] == 1){
        switch($_SESSION["msg"]){
            case "success":
                $msghtml = '<p style="font-size: 30px" class="loginError text-success">座席の登録が完了しました。</p><p style="font-size: 30px" class="loginError text-success">Check-in completed.</p>';
            break;
            case "fail":
                $msghtml = '<p style="font-size: 30px" class="loginError text-danger">登録に失敗しました。もう一度お試しください。</p><p style="font-size: 30px" class="loginError text-danger">Check-in failed. Try again.</p>';
            break;
            case "reserved":
                $msghtml = '<p style="font-size: 30px" class="loginError text-danger">既に登録済みです。座席を変更する場合は、一度退出手続きを踏んでください。</p><p style="font-size: 30px" class="loginError text-danger">You already checked-in.</p>';
            break;
        }
      }else if($_SESSION["seatReservaton"] == 2){
        switch($_SESSION["msg"]){
            case "success":
                $msghtml = '<p style="font-size: 30px" class="loginError text-success">退出が完了しました。</p><p style="font-size: 30px" class="loginError text-success">Check-out completed.</p>';
            break;
            case "fail":
                $msghtml = '<p style="font-size: 30px" class="loginError text-danger">退出に失敗しました。もう一度お試しください。</p><p style="font-size: 30px" class="loginError text-danger">Check-out failed. Try again.</p>';
            break;
            case "different":
                $msghtml = '<p style="font-size: 30px" class="loginError text-danger">学籍番号が一致しません。</p><p style="font-size: 30px" class="loginError text-danger">Wrong ID. Try again.</p>';
            break;
        }
        $_SESSION["msg"] = "";
      }
        $_SESSION["seatReservaton"] = 0;
    }

    $legends = "";
    if($type == 2){
        $legends = '<span class="text-success">緑</span>: 空席　<span class="text-warning">黄色</span>: 使用中　<span class="text-info">水色</span>: 使用中（インターネット有）　<span class="text-secondary">グレー</span>: 使用不可';
        $title = "自習室の空席情報";
    }else{
        $title = "<span class='text-success'>入室</span>: 座りたい座席をクリックしてください。<br/><span class='text-danger'>退出</span>: 座っていた座席をクリックしてください。<br/><br/><span class='text-success'>Check-in</span>: Choose and click the seat.<br/><span class='text-danger'>Check-out</span>: Click your seat.";
        $legends = '<span class="text-success">緑</span>: 空席　<span class="text-danger">赤</span>: 使用中　<span class="text-secondary">グレー</span>: 使用不可';
        $legends .= '<br/><span class="text-success">Green</span>: Vacant　<span class="text-danger">Red</span>: Used　<span class="text-secondary">Grey</span>: Unavailable';
    }

?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php
if($_SESSION["role"] != 1)
  echo getNavbar();
else
  echo "<br/>";
?>

<div class="container" style="margin-top: 30px">
    <div class="row">
        <div class="main col-md-12 col-xs-12">
            <h2 class="text-dark"><?php echo $title; ?></h2>
            <br/>
            <h4><?php echo $legends; ?></h4>
            <?php
              if($type == 2){
                print('<input type="button" onclick="window.location.href = \'controlSeats.php\'" class="btn btn-primary" style="width: 200px" value="座席数変更" />');
              }

            ?>
            <br/>
            <?php echo $msghtml;?>
            <br/>
            <div id="seatMap">
            <?php
              echo displaySeatsInfo($type);
            ?>
            </div>
            </div>
            <br/>
        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/reload.js"></script>
</body></html>
