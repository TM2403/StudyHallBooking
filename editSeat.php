<?php
    ini_set('display_errors', TRUE);
    require_once("databases/auth/auth.php");
    require_once("php/components.php");
    require_once(dirname(__FILE__) . "/databases/seats/seatsInfo.php");
    require_once(dirname(__FILE__) . "/databases/seats/seatLog.php");


    $username = $_SESSION["username"];
    $role = $_SESSION["role"];

    if(!isset($_GET["seat"])){
        header("Location: index.php");
        exit(1);
    }

    $seatData = getSeatInfo($_GET["seat"]);

    function displayStatus($status){
        global $seatData;
        $html = "";
        switch($status){
            case 0:
                $html = "<span class='text-success'>空席</span>";
            break;
            case 1:
            case 2:
                if($seatData["currentID"] != "9999999" && $seatData["currentID"] != "0000000"){
                    $student = getStudentFromID($seatData["currentID"]);
                    if(preg_match("/^[a-zA-Z0-9]+$/", $student["lastName"]) && preg_match("/^[a-zA-Z0-9]+$/", $student["firstName"])){
                        $fullName = $student["firstName"] ." " .  $student["lastName"];
                    }else{
                      $fullName = $student["lastName"] . $student["firstName"];
                    }
                    $class = getStringClass($student["grade"], $student["class"]);
                    $classInfo = $class . " #" . $student["studentNum"];
                }else{
                  switch($seatData["currentID"]){
                      case "0000000":
                          $fullName = "教職員";
                      break;
                      case "9999999":
                          $fullName = "ゲスト";
                      break;
                  }
                  $classInfo = "";
                }
                $html = "<span class='text-danger'>利用中</span><br/>" . $fullName . " " . $classInfo;
            break;
            case 9:
                $html = "<span class='text-secondary'>利用不可</span>";
            break;
        }
        return $html;
    }

?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php echo getNavbar() ?>
<div class="container">
    <div class="row">
            <div class="main col-md-12 col-xs-12">
              <div class="card border-info">
                    <div class="card-header">
                        <h2 class="card-title text-info">座席情報</h2>
                    </div>
                    <div class="card-body">
                        <table class="table text-center">
                            <tr><td style="width: 50%">座席番号: </td><td style="width: 50%"><?php echo $_GET["seat"]  ?>番</td></tr>
                            <tr><td>ステータス: </td><td><?php echo displayStatus($seatData["status"]) ?></td></tr>
                        </table>
                        <div class="d-flex">
                        <input type="button" onclick="window.location.href = 'index.php'" class="tableButton btn btn-secondary" style="width: 100px" value="戻る" />

                        <?php
                          if($seatData["status"] != 9){
                            echo '<input type="button" class="btn btn-success tableButton" onclick="window.location.replace(\'databases/seats/exit.php?type=2&seat=' .  $_GET["seat"] . '\')" value="空席にする" />';
                          }
                        ?>
                      </div>
                    </div>
                </div>
                <br/>
                <div class="card border-success">
                    <div class="card-header">
                        <h2 class="card-title text-success">利用履歴（直近10件）</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                          <thead class="thead-light">
                            <tr><th>学籍番号</th><th>氏名</th><th>クラス</th><th>入室</th><th>退室</th></tr>
                          </thead>
                          <tbody>
                            <?php echo displayASeatLog(getASeatLog($_GET["seat"])); ?>
                          </tbody>
                        </table>
                    </div>
                </div>
            <br/>
        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
