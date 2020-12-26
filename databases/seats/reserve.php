<?php
  ini_set('display_errors', TRUE);
  session_start();
  require_once(dirname(__FILE__) . "/../connect.php");
  require_once(dirname(__FILE__) . "/seatsInfo.php");

  $_SESSION["seatReservaton"] = 1;

  if(getSeatFromOccupant($_SESSION["studentID"]) != 0 && $_SESSION["studentID"] != "0000000" && $_SESSION["studentID"] != "9999999"){
      $_SESSION["msg"] = "reserved";
      header("Location: ../../index.php");
      exit(1);
  }

  if(getSeatStatus($_SESSION["seatNumber"]) != 0){
      $_SESSION["msg"] = "fail";
      header("Location: ../../index.php");
      exit(1);
  }



  $student = getStudentFromID($_SESSION["studentID"]);

  reserveSeat($_SESSION["seatNumber"], $_GET["internet"], $_SESSION["studentID"]);
  $_SESSION["studentID"] = "";
  $_SESSION["msg"] = "success";
  header("Location: ../../index.php");




  function reserveSeat($seatNumber, $internetUse, $ID){
    $status = $internetUse + 1;

    $pdo = connectScannerDatabase();
    $sql = "UPDATE seatList SET currentID = :ID, status = :status WHERE seatNumber = :seatNumber";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ID", $ID);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":seatNumber", $seatNumber);

    $stmt->execute();

    $sql = "INSERT INTO seatLog(seatNumber, studentID, status, checkInTime) VALUES (:seatNumber, :ID, :status, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ID", $ID);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":seatNumber", $seatNumber);
    $stmt->execute();

  }
?>
