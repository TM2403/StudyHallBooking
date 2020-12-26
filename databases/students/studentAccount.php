<?php
    ini_set('display_errors', TRUE);

    require(dirname(__FILE__) . "/../auth/auth.php");
    require_once(dirname(__FILE__) . "/../connect.php");

    //Anti CSRF
    if($_POST["token"] != $_SESSION["token"]){
        header("Location: ../../index.php");
    }
    $_SESSION["token"] = "";

    if(!$_POST["id"] || !$_POST["lastName"] || !$_POST["firstName"] || !$_POST["grade"] || !$_POST["class"] || !$_POST["studentNum"]){
      header("Location: ../../editStudent.php?error=1");
      exit(1);
    }

    $pdo = connectScannerDatabase();
    $sql = "INSERT INTO students(studentID, lastName, firstName, grade, class, studentNum) VALUES (:studentID, :lastName, :firstName, :grade, :class, :studentNum) ON DUPLICATE KEY UPDATE lastName = :lastName2, firstName = :firstName2, grade = :grade2, class = :class2, studentNum = :studentNum2";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":studentID", htmlspecialchars($_POST["id"]));
    $stmt->bindParam(":lastName", htmlspecialchars($_POST["lastName"]));
    $stmt->bindParam(":firstName", htmlspecialchars($_POST["firstName"]));
    $stmt->bindParam(":grade", htmlspecialchars($_POST["grade"]));
    $stmt->bindParam(":class", htmlspecialchars($_POST["class"]));
    $stmt->bindParam(":studentNum", htmlspecialchars($_POST["studentNum"]));
    $stmt->bindParam(":lastName2", htmlspecialchars($_POST["lastName"]));
    $stmt->bindParam(":firstName2", htmlspecialchars($_POST["firstName"]));
    $stmt->bindParam(":grade2", htmlspecialchars($_POST["grade"]));
    $stmt->bindParam(":class2", htmlspecialchars($_POST["class"]));
    $stmt->bindParam(":studentNum2", htmlspecialchars($_POST["studentNum"]));
    $stmt->execute();

    header("Location: ../../checkIn.php?step=4");
?>
