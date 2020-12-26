<?php
    ini_set('display_errors', TRUE);
    session_start();
    require_once(dirname(__FILE__) . "/databases/seats/seatsInfo.php");
    require_once("php/components.php");

    $type = 0;

    $buttons = "";

    if(!isset($_GET["seat"]) && !isset($_GET["step"])){
        header("Location: index.php");
        exit(1);
    }else if(isset($_GET["seat"])){
        $seatNumber = $_GET["seat"];
        $_SESSION["seatNumber"] = $_GET["seat"];
        $buttons = '<h1 class="text-dark text-center">' . $seatNumber . '番を退出しますか？</h1>
        <h1 class="text-dark text-center">Checking-out seat #' . $seatNumber . '？</h1>
        <div class="text-center">
        <button class="bigButton btn btn-warning" onclick="location.href=\'checkOut.php?step=2\'">退出する<br/>Yes</button>
        <button class="bigButton btn btn-secondary" onclick="history.back()">戻る<br/>Back</button>
        <div>';
    }else if(isset($_GET["step"])){
        switch($_GET["step"]){
            case 2:
              $buttons = '<h1 class="text-dark text-center">図書カードのバーコードをスキャンするか、<br/>学籍番号を入力してください。</h1>
              <h1 class="text-dark text-center">Scan your library card or enter your student ID.</h1>
              <div class="text-center">

              <form method="POST" style="font-size: 20px; margin-top: 100px" class="form" action="databases/seats/exit.php">
              <h4>学籍番号/Student ID:</h4> <input type="text" class="form-control w-50" style="margin-left:25%" autofocus name="id">
              <br/>
              <input class=" btn btn-primary ml-5 middleButton" type="submit" value="送信　Send">
              <input class=" btn btn-secondary ml-5 middleButton" type="button" value="取り消し Cancel" onclick="location.href=\'index.php\'">
              </form>
              </div>
              <br/>
              <div class="card border-info">
                    <div class="card-body">
                        <table class="table text-center">
                            <tr><td style="width: 50%">教員の場合<br/>Teacher</td><td style="width: 50%">0を7回入力<br/>Enter 7 0s</td></tr>
                            <tr><td>ゲストの場合<br/>Guest</td><td>9を7回入力<br/>Enter 7 9s</td></tr>
                        </table>
                    </div>
                </div>

              ';
            break;

        }
    }

?>
<?php echo getHeader() ?>
<div id="wrapper">
<div class="container">
    <div class="row">
        <div class="main col-md-12 col-xs-12" style="margin-top: 100px;">
              <?php echo $buttons ?>
          </div>
        </div>
    </div>
</div>
</div>
</body></html>
