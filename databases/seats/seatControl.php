<?php
    ini_set('display_errors', TRUE);
    session_start();
    require_once(dirname(__FILE__) . "/../connect.php");
    require_once(dirname(__FILE__) . "/seatsInfo.php");

    $unavailableSeats = $_POST["unavailableSeats"];
    $seats = getAllSeats();


    foreach($unavailableSeats as $seatNum){
      $seats[$seatNum - 1]["status"] += 10;
    }

    $pdo = connectScannerDatabase();
    for($i = 1; $i < 55; $i++){
      global $pdo;
        if($seats[$i - 1]["status"] == 10){
            $sql = "UPDATE seatList SET status = 9 WHERE seatNumber = :seatNumber";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":seatNumber", $i);
            $stmt->execute();
        }else if($seats[$i - 1]["status"] == 9){
            $sql = "UPDATE seatList SET status = 0 WHERE seatNumber = :seatNumber";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":seatNumber", $i);
            $stmt->execute();
        }
    }

    header("Location: ../../index.php");

?>
