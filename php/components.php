<?php
    ini_set('display_errors', TRUE);
    require_once(dirname(__FILE__) . "/names.php");

    function getFooter(){
      return  "<footer>Copyright &copy; 2020 広尾学園</footer>";
    }

    function getHeader(){
        $header = "";
        $title = array();
        $title["index.php"] = "空席状況 | " . SERVICE＿NAME;
        $title["help.php"] = "ヘルプ | " . SERVICE＿NAME;
        $title["login.php"] = "ログイン | " . SERVICE＿NAME;
        $title["register.php"] = "新規登録 | " . SERVICE＿NAME;
        $title["account.php"] = "アカウント | " . SERVICE＿NAME;
        $title["changePassword.php"] = "パスワード変更 | " . SERVICE＿NAME;
        $title["students.php"] = "Students | " . SERVICE＿NAME;
        $title["teachers.php"] = "Teachers | " . SERVICE＿NAME;
        $title["newTeacher.php"] = "Teachers | " . SERVICE＿NAME;
        $title["checkIn.php"] = "登録手続き | " . SERVICE＿NAME;
        $title["checkOut.php"] = "退出手続き | " . SERVICE＿NAME;
        $title["controlSeats.php"] = "座席管理 | " . SERVICE＿NAME;
        $title["editSeat.php"] = "座席情報 | " . SERVICE＿NAME;
        $title["editStudent.php"] = "情報更新 | " . SERVICE＿NAME;




        $header = '<!DOCTYPE html><html lang="ja"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>' . $title[basename($_SERVER['SCRIPT_FILENAME'])] . '</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </head><body>';

        return $header;
    }

    function getSubHeader(){
        $header = "";
        $title = array();
        $title["newStudent.php"] = "Students | RoomEntry";
        $title["editStudent.php"] = "Students | RoomEntry";
        $title["viewStudent.php"] = "Students | RoomEntry";
        $title["newTeacher.php"] = "Teachers | RoomEntry";
        $title["viewTeacher.php"] = "Teachers | RoomEntry";
        $title["editTeacher.php"] = "Teachers | RoomEntry";



        $header = '<!DOCTYPE html><html lang="ja"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>' . $title[basename($_SERVER['SCRIPT_FILENAME'])] . '</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        </head><body>';

        return $header;
    }

    function getSubNavbar(){
        $active = array("", "", "", "");
        switch(basename($_SERVER['SCRIPT_FILENAME'])){
            case "newStudent.php":
                $active[1] = "active";
            break;
            case "viewStudent.php":
                $active[1] = "active";
            break;
            case "editStudent.php":
                $active[1] = "active";
            break;
        }
        $navbar = '<nav class="navbar navbar-expand-sm navbar-light bg-light mt-3 mb-3 sticky-top">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="../"><img id="logo" src="../images/logo.png"/></a>
          <div class="collapse navbar-collapse justify-content-start">
              <ul class="navbar-nav">
                <li class="nav-item ' . $active[0] . ' ">
                      <a class="nav-link" href="../">Attendance</a>
                  </li>
                  <li class="nav-item ' . $active[1] . '">
                      <a class="nav-link" href="../students.php">Manage Student</a>
                  </li>';

                  if($_SESSION["type"] == 1){
                  $navbar .= '
                  <li class="nav-item ' . $active[2] . '">
                      <a class="nav-link" href="../teachers.php">Manage Teachers</a>
                  </li>';
                }
              $navbar .= '</ul>
          </div>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item ' . $active[3] . '">
                    <a class="nav-link" href="../account.php">Your Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="../logout.php">Logout</a>
                </li>
            </ul>
          </div>
        </nav>';
        return $navbar;
    }

    function getNavbar(){
        $active = array("", "", "", "");
        switch(basename($_SERVER['SCRIPT_FILENAME'])){
            case "index.php":
                $active[0] = "active";
            break;
            case "account.php":
                $active[1] = "active";
            break;
            case "students.php":
                $active[2] = "active";
            break;
            case "help.php":
                $active[3] = "active";
            break;
        }
        $navbar = '<nav class="navbar navbar-expand-sm navbar-light bg-light mt-3 mb-3">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img id="logo" src="images/logo.png"/></a>
          <div class="collapse navbar-collapse justify-content-start">
              <ul class="navbar-nav">
                <li class="nav-item ' . $active[0] . ' ">
                      <a class="nav-link" href="index.php">空席状況</a>
                  </li>';

                  if(isset($_SESSION["id"])){
                    $navbar .= '<li class="nav-item ' . $active[1] . '">
                          <a class="nav-link" href="account.php">アカウント</a>
                      </li>';
                  }


                /*  if(isset($_SESSION["id"]) && $_SESSION["role"] == 2){
                  $navbar .= '
                  <li class="nav-item ' . $active[2] . '">
                      <a class="nav-link" href="students.php">生徒情報</a>
                  </li>';
                }*/
              $navbar .= '</ul>
          </div>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">';
                /*<li class="nav-item ' . $active[3] . '">
                    <a class="nav-link" href="help.php">ヘルプ</a>
                </li>';*/

            if(isset($_SESSION["id"])){
                $navbar .= '<li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">ログアウト</a>
                </li>';
            }else{
                $navbar .= '<li class="nav-item">
                    <a class="nav-link text-warning" href="login.php">ログイン</a>
                </li>';
            }

            $navbar .= '</ul></div></nav>';
        return $navbar;
    }


    function getSelectOption($grade){
        $selected = array_fill(0,8,"");
        $selected[$grade] = "selected";
        $html = '
        <select name="grade" class="form-control">
            <option disabled  ' . $selected[7] . ' >学年を選択</option>
            <option value="1" ' . $selected[1] . ' >M1</option>
            <option value="2" ' . $selected[2] . ' >M2</option>
            <option value="3" ' . $selected[3] . ' >M3</option>
            <option value="4" ' . $selected[4] . ' >H1</option>
            <option value="5" ' . $selected[5] . ' >H2</option>
            <option value="6" ' . $selected[6] . ' >H3</option>
            <option value="0" ' . $selected[0] . ' >無し</option>
        </select>';
        return $html;
    }

    function getStringRole($role){
      $stringRole = "";
      switch($role){
          case 0:
              $stringRole = "サイネージ";
          break;
          case 1:
              $stringRole = "登録用";
          break;
          case 2:
              $stringRole = "管理者用";
          break;
      }
      return $stringRole;
    }

    function getStringClass($grade, $class){
        $classStr = "";

        if($grade == 0 && $class == 0)
            return "無し";

        switch($grade){
            case 1:
              $classStr .= "M1";
            break;
            case 2:
              $classStr .= "M2";
            break;
            case 3:
              $classStr .= "M3";
            break;
            case 4:
              $classStr .= "H1";
            break;
            case 5:
              $classStr .= "H2";
            break;
            case 6:
              $classStr .= "H3";
            break;
        }
        $classStr .= "-";
        $classStr .= $class;
        return $classStr;
    }
?>
