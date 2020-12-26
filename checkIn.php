<?php
    ini_set('display_errors', TRUE);
    session_start();
    require_once(dirname(__FILE__) . "/databases/seats/seatsInfo.php");
    require_once(dirname(__FILE__) . "/databases/students/studentData.php");
    require_once(dirname(__FILE__) . "/php/components.php");

    $type = 0;

    $buttons = "";

    if(!isset($_GET["seat"]) && !isset($_GET["step"])){
        header("Location: index.php");
        exit(1);
    }else if(isset($_GET["seat"])){
        $seatNumber = $_GET["seat"];
        $_SESSION["seatNumber"] = $_GET["seat"];
        $buttons = '<h1 class="text-dark text-center">' . $seatNumber . '番でよろしいですか？</h1>
        <h1 class="text-dark text-center">Reserving Seat #' . $seatNumber . '？</h1>
        <div class="text-center">
        <button class="bigButton btn btn-primary" onclick="location.href=\'checkIn.php?step=2\'">はい<br>Yes</button>
        <button class="bigButton btn btn-secondary" onclick="history.back()">戻る<br/>Back</button>
        <div>';
    }else if(isset($_GET["step"])){
        switch($_GET["step"]){
            case 2:
              $buttons = '<h1 class="text-dark text-center">図書カードのバーコードをスキャンするか、<br/>学籍番号を入力してください。</h1>
              <h1 class="text-dark text-center">Scan your library card or enter your student ID.</h1>
              <div class="text-center">

              <form method="POST" style="font-size: 20px; margin-top: 100px" class="form" action="?step=3">
              <h4>学籍番号/Student ID:</h4> <input type="text" class="form-control w-50" style="margin-left:25%" autofocus name="id">
              <br/>
              <input class=" btn btn-primary ml-5 middleButton" type="submit" value="次へ Continue">
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
            case 3:
              if(!isset($_POST["id"])){
                header("Location: index.php");
                exit(1);
              }else if($_POST["id"] == "0000000" || $_POST["id"] == "9999999"){
                $_SESSION["studentID"] = $_POST["id"];
                header("Location: checkIn.php?step=4");
                exit(1);
              }else{
                  $_SESSION["studentID"] = $_POST["id"];
                  $student = getStudentFromID($_POST["id"]);
                  if(preg_match("/^[a-zA-Z0-9]+$/", $student["lastName"]) && preg_match("/^[a-zA-Z0-9]+$/", $student["firstName"])){
                      $fullName = $student["firstName"] ." " .  $student["lastName"];
                  }else{
                    $fullName = $student["lastName"] . $student["firstName"];
                  }
                  if(!empty($student) != 0){
                      $buttons = '
                      <div class="text-center">
                      <div class="card border-info">
                            <div class="card-header">
                                <h2 class="card-title text-info">生徒情報の確認/Your Information</h2>
                            </div>
                            <div class="card-body">
                                <table class="table text-center">
                                    <tr><td style="width: 50%">学籍番号<br/>Student ID</td><td style="width: 50%">' . $_POST["id"] . '</td></tr>
                                    <tr><td>氏名<br/>Full Name</td><td>' . $fullName . '</td></tr>
                                    <tr><td>学年/クラス<br/>Homeroom class</td><td>' . getStringClass($student["grade"], $student["class"]) . '</td></tr>
                                    <tr><td>出席番号<br/>Student ID</td><td>' . $student["studentNum"] . '</td></tr>
                                </table>
                            </div>
                        </div>
                        <br/>
                      <button class="middleButton btn btn-info" onclick="location.href=\'checkIn.php?step=4\'">変更なし<br/>This information is correct.</button>
                      <button class="middleButton btn btn-warning" onclick="location.href=\'editStudent.php\'">情報更新<br/>Update my information.</button>
                      </form>
                      <br/>
                      <br/>
                      <button class="cancelButton btn btn-secondary" onclick="location.href=\'index.php\'">取り消す/Cancel</button>
                      </div>
                      ';
                    }else{
                        header("Location: editStudent.php");
                        exit(1);
                    }
              }
            break;
           case 4:
              $buttons = '<h1 class="text-dark text-center">インターネットは利用しますか<br/>Are you going to use Internet?</h1>
              <div class="text-center">
              <button class="bigButton btn btn-primary" onclick="location.href=\'databases/seats/reserve.php?step=3&internet=1\'">利用します<br/>Yes</button>
              <button class="bigButton btn btn-secondary" onclick="location.href=\'databases/seats/reserve.php?step=3&internet=0\'">利用しません<br/>No</button>
              <br/><br/><button class="cancelButton btn btn-secondary" onclick="location.href=\'index.php\'">取り消す/Cancel</button></div>
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
