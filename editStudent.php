<?php
    session_start();
    ini_set('display_errors', TRUE);
    $token = bin2hex(random_bytes(16));
    $_SESSION["token"] = $token;

    require_once("php/components.php");
    require_once(dirname(__FILE__) . "/databases/students/studentData.php");


    $msg = '';
    if(isset($_GET["error"])){
      switch($_GET["error"]){
          case 1:
            $msg = '<p class="loginError text-danger">全て入力してください。<br/>Enter all fields.</p>';
          break;
      }
    }

    function studentData($arg){
        $student = getStudentFromID($_SESSION["studentID"]);
        if(!empty($student)){
          return $student[$arg];
        }else{
          if($arg == "grade")
            return 7;
          else
            return "";
        }
    }


?>
<?php echo getHeader() ?>
<div id="wrapper">
<?php //echo getNavbar() ?>
<div class="container">
    <div class="row">
        <div class="main col-md-12 col-xs-12">
            <br/>
            <br/>
            <div class="card border-info">
                <div class="card-header">
                    <h2 class="card-title text-info">生徒情報入力/Editing your information</h2>
                </div>
                <div class="card-body">
                  <?php echo $msg;?>
                    <form method="POST" action="databases/students/studentAccount.php" class="accountForm">
                        <table class="table">
                            <tr><td>学籍番号<br/>Student ID</td><td><input type="text" class="form-control" name="id" value="<?php echo $_SESSION["studentID"]?>"/></td></tr>
                            <tr><td>姓<br/>Last name</td><td><input type="text" class="form-control" name="lastName" value="<?php echo studentData("lastName")?>"/></td></tr>
                            <tr><td>名<br/>First name</td><td><input type="text" class="form-control" name="firstName" value="<?php echo studentData("firstName")?>"/></td></tr>
                            <tr><td>学年<br/>Grade</td><td><?php echo getSelectOption(studentData("grade")) ?></td></tr>
                            <tr><td>クラス<br/>Class</td><td><input type="number" class="form-control" name="class" min="1" max="9" value="<?php echo studentData("class")?>"/></td></tr>
                            <tr><td>出席番号<br/>Student Number</td><td><input type="number" class="form-control" name="studentNum" min="1" max="40" value="<?php echo studentData("studentNum")?>"/></td></tr>
                        </table>
                        <input type="hidden" value="<?php echo $token ?>" name="token"/>
                        <div class="d-flex">
                            <input type="submit" class="btn btn-primary" value="登録 Register" />
                            <input type="button" onclick="location.href='index.php'" class="btn btn-secondary" value="取消 Cancel" />
                        </div>
                    </form>
                </div>
            </div>
            <br/>

        </div>
    </div>
</div>
<?php echo getFooter() ?>
</div>
</body></html>
