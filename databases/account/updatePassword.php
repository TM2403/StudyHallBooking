<?php
    ini_set('display_errors', TRUE);

    require(dirname(__FILE__) . "/../auth/auth.php");
    require_once(dirname(__FILE__) . "/../connect.php");

    //Anti CSRF
    if($_POST["token"] != $_SESSION["token"]){
        header("Location: ../../changePassword.php");
    }
    $_SESSION["token"] = "";

    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["password"];
    $newPassword2 = $_POST["password2"];

    $pdo = connectLoginDatabase();
    $sql = "SELECT password FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_SESSION["id"]);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $hashedPassword = $result[0][0];

    if(!password_verify($oldPassword,$hashedPassword)){
        //echo var_dump(password_verify($oldPassword,$hashedPassword);
        header("Location: ../../changePassword.php?error=1");
    }else if(strcmp($newPassword, $newPassword2) != 0){
        header("Location: ../../changePassword.php?error=2");
    }else{
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":password", $hashedNewPassword);
        $stmt->bindValue(":id", $_SESSION["id"]);
        $stmt->execute();
        header("Location: ../../account.php");
    }

?>
