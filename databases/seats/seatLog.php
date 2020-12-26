<?php
    ini_set('display_errors', TRUE);
    require_once(dirname(__FILE__) . "/../connect.php");
    require_once(dirname(__FILE__) . "/seatsInfo.php");

    function getASeatLog($seatNumber){
      $pdo = connectScannerDatabase();
      $sql = "SELECT studentID, status, checkInTime, IFNULL(checkOutTime, '') FROM seatLog WHERE seatNumber = :seatNumber ORDER BY checkInTime DESC LIMIT 0, 10";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":seatNumber", $seatNumber);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }

    function displayASeatLog($log){
        $html = "";
        foreach($log as $components){
          if($components["studentID"] != "0000000" && $components["studentID"] != "9999999"){
              $student = getStudentFromID($components["studentID"]);
              if(preg_match("/^[a-zA-Z0-9]+$/", $student["lastName"]) && preg_match("/^[a-zA-Z0-9]+$/", $student["firstName"])){
                  $fullName = $student["firstName"] ." " .  $student["lastName"];
              }else{
                $fullName = $student["lastName"] . $student["firstName"];
              }
              $class = getStringClass($student["grade"], $student["class"]);
              $classInfo = $class . " #" . $student["studentNum"];
              $html .= "<tr><td>" . $components["studentID"] . "</td><td>" . $fullName . "</td><td>" . $class . "</td><td>" . $components["checkInTime"] . "</td><td>" . $components["IFNULL(checkOutTime, '')"] . "</td></tr>";
          }else{
            switch($components["studentID"]){
                case "0000000":
                    $html .= "<tr><td>無し</td><td>教職員</td><td></td><td>" . $components["checkInTime"] . "</td><td>" . $components["IFNULL(checkOutTime, '')"] . "</td></tr>";
                break;
                case "9999999":
                    $html .= "<tr><td>無し</td><td>ゲスト</td><td></td><td>" . $components["checkInTime"] . "</td><td>" . $components["IFNULL(checkOutTime, '')"] . "</td></tr>";
                break;
            }

          }
        }
        return $html;
    }
?>
