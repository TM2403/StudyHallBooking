<?php
  ini_set('display_errors', TRUE);
  session_start();
  require_once(dirname(__FILE__) . "/../connect.php");
  require_once(dirname(__FILE__) . "/seatsInfo.php");

  if(isset($_GET["type"]) && $_GET["type"] == 2){
      emptySeat($_GET["seat"]);
      header("Location: ../../editSeat.php?seat=" . $_GET["seat"]);
      exit(0);
  }

  $_SESSION["seatReservaton"] = 2;

  if(getSeatStatus($_SESSION["seatNumber"]) == 0){
      $_SESSION["msg"] = "fail";
      header("Location: ../../index.php");
      exit(1);
  }

  $seatData = getSeatInfo($_SESSION["seatNumber"]);

  if($seatData["currentID"] != $_POST["id"]){
      $_SESSION["msg"] = "different";
      header("Location: ../../index.php");
      exit(1);
  }

  emptySeat($_SESSION["seatNumber"]);
  $_SESSION["msg"] = "success";
  header("Location: ../../index.php");

  function emptySeat($seatNumber){
    $pdo = connectScannerDatabase();
    $sql = "UPDATE seatList SET currentID = NULL, status = 0 WHERE seatNumber = :seatNumber";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":seatNumber", $seatNumber);
    $stmt->execute();

    $sql = "UPDATE seatLog SET checkOutTime = NOW() WHERE seatNumber = :seatNumber AND checkOutTime IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":seatNumber", $seatNumber);
    $stmt->execute();

  }


  /*echo "Seat: " . $_SESSION["seatNumber"] . "\n";
  echo "Internet: " . $_SESSION["internetUse"] . "\n";
  echo "ID: " . $_POST["id"] . "\n";*/


?>
