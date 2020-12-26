<?php
    session_start();
    ini_set('display_errors', TRUE);
    require_once(dirname(__FILE__) . "/../connect.php");

    $pdo = connectLoginDatabase();

    //Anti CSRF
    if($_POST["token"] != $_SESSION["loginToken"]){
        header("Location: ../../login.php?error=true");
    }
    $_SESSION["loginToken"] = "";

    $username = $_POST["username"];
  	$password = $_POST["password"];

    //Get User PASSWORD
    if(password_verify($password, getUserPassword($username))){
        $userData = getUserData($username);
        beginSession($userData, $username);
        header("Location: ../../");
    }else{
        header("Location: ../../login.php?error=true");
    }


    function getUserPassword($username){
        global $pdo;
        $sql = "SELECT password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $password_hash = $result[0][0];
        return $password_hash;
    }

    function getUserData($username){
        global $pdo;
        $sql = "SELECT id, role FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $userData = $result[0];
        return $userData;
    }

    function beginSession($userData, $username){
      $_SESSION["id"] = $userData["id"];
      $_SESSION["username"] = $username;
      $_SESSION["role"] = $userData["role"];

      /*
       $_SESSION["student"]["email"] = $username;
       $_SESSION["student"]["lastName"] = $userData["lastName"];
       $_SESSION["student"]["firstName"] = $userData["firstName"];
       $_SESSION["student"]["grade"] = $userData["grade"];
       $_SESSION["student"]["class"] = $userData["class"];
       $_SESSION["student"]["studentNum"] = $userData["studentNum"];
       */
    }

?>
