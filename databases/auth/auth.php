<?php
    //Used by require_once() only
    session_start();
    if(!isset($_SESSION["id"])){
      header("Location: login.php");
    }else{
    /*    $id = $_SESSION["id"];
        $email = $_SESSION["email"];
        $firstName = $_SESSION["firstName"];
        $lastName = $_SESSION["lastName"];
        $grade = $_SESSION["grade"];
        $class = $_SESSION["class"];
        $type = $_SESSION["type"];
        $fullName = $firstName . " " . $lastName;*/
    }

    $role = $_SESSION["role"];
    if($role == 0){
        switch(basename($_SERVER['SCRIPT_FILENAME'])){
            case "teachers.php":
                header("Location: /");
                exit(1);
            break;
            case "teachers.php":
                header("Location: /");
                exit(1);
            break;
            case "viewTeachers.php":
                header("Location: /");
                exit(1);
            break;
            case "editTeachers.php":
                header("Location: /");
                exit(1);
            break;
        }
    }



    function getGrade($code){
        return floor($code / 10);
    }

    function getClass($code){
        return $code % 10;
    }

?>
