<?php
    ini_set('display_errors', TRUE);
    require_once(dirname(__FILE__) . "/../connect.php");
    require_once(dirname(__FILE__) . "/../students/studentData.php");
    require_once(dirname(__FILE__) . "/../../php/components.php");

    function getAllSeats(){
      $pdo = connectScannerDatabase();
      $sql = "SELECT seatNumber, currentID, status FROM seatList ORDER BY seatNumber ASC";

      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }

    function getSeatStatus($seatNumber){
      $pdo = connectScannerDatabase();
      $sql = "SELECT status FROM seatList WHERE seatNumber = :seatNumber";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":seatNumber", $seatNumber);

      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result[0]["status"];
    }

    function getSeatInfo($seatNumber){
      $pdo = connectScannerDatabase();
      $sql = "SELECT * FROM seatList WHERE seatNumber = :seatNumber";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":seatNumber", $seatNumber);

      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result[0];
    }

    function getSeatFromOccupant($ID){
      $pdo = connectScannerDatabase();
      $sql = "SELECT COUNT(seatNumber) FROM seatList WHERE currentID = :ID";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":ID", $ID);

      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result[0]["COUNT(seatNumber)"];
    }



    function displaySeatsInfo($type){
        $data = getAllSeats();
        $html = '<div class="container border border-secondary "><div class="row seats"></div>';
        $i = 54;
        while($i > 0){
            $fullName = "&nbsp;";
            $classInfo = "&nbsp;";
            $moreInfo = "";
            $status = $data[$i - 1]["status"];
            if($status == 1 || $status == 2){
                if($data[$i - 1]["currentID"] != "0000000" && $data[$i - 1]["currentID"] != "9999999"){
                    $student = getStudentFromID($data[$i - 1]["currentID"]);
                    if(preg_match("/^[a-zA-Z0-9]+$/", $student["lastName"]) && preg_match("/^[a-zA-Z0-9]+$/", $student["firstName"])){
                        $fullName = $student["firstName"] ." " .  $student["lastName"];
                    }else{
                      $fullName = $student["lastName"] . $student["firstName"];
                    }


                    $class = getStringClass($student["grade"], $student["class"]);
                    $classInfo = $class . " #" . $student["studentNum"];
                    if($type == 2)
                        $moreInfo = "<br/>" . $data[$i - 1]["currentID"];
                }else{
                    switch($data[$i - 1]["currentID"]){
                        case "0000000":
                            $fullName = "教職員/Teacher";
                        break;
                        case "9999999":
                            $fullName = "ゲスト/Guest";
                        break;
                    }
                }
            }

            if($i == 54 || $i == 51){
              $html .= '<div class="row seats"><div class="col"></div><div class="col"></div><div class="col"></div><div class="col"></div>';
              $html .= '<div class="col ' . getStatusColor($status, $type) . ' border border-dark "'  . getSeatButton($type, $status, $i) . '>' . $i . '<br/>' . getOccupantInfo($type, $fullName, $classInfo, $moreInfo) . '</div>';
              $i--;
            }else if($i % 12 == 1){
                $html .= '<div class="col ' . getStatusColor($status, $type) . ' border border-dark "'  . getSeatButton($type, $status, $i) . '>' . $i . '<br/>' . getOccupantInfo($type, $fullName, $classInfo, $moreInfo) . '</div></div>';
                $html .= '<div class="row seats"></div>';
                $i--;
            }else if($i % 12 == 4){
                $html .= '<div class="col ' . getStatusColor($status, $type) . ' border border-dark "'  . getSeatButton($type, $status, $i) . '>' . $i . '<br/>' . getOccupantInfo($type, $fullName, $classInfo, $moreInfo) . '</div></div>';
                if($i == 52)
                  $i--;
                else
                  $i += 5;
            }else if($i % 12 == 0 || $i % 12 == 9){
                $html .= '<div class="row seats">';
                $html .= '<div class="col ' . getStatusColor($status, $type) . ' border border-dark "'  . getSeatButton($type, $status, $i) . '>' . $i . '<br/>' . getOccupantInfo($type, $fullName, $classInfo, $moreInfo) . '</div>';
                $i--;
            }else if($i % 12 == 7 || $i % 12 == 10){
                $html .= '<div class="col ' . getStatusColor($status, $type) . ' border border-dark "'  . getSeatButton($type, $status, $i) . '>' . $i . '<br/>' . getOccupantInfo($type, $fullName, $classInfo, $moreInfo) . '</div>';
                $html .= '<div class="col"></div>';
                $i -= 4;
            }else{
                $html .= '<div class="col ' . getStatusColor($status, $type) . ' border border-dark "'  . getSeatButton($type,$status, $i) . '>' . $i . '<br/>' . getOccupantInfo($type, $fullName, $classInfo, $moreInfo) . '</div>';
                $i--;
            }

        }

          return $html;
    }

    function displaySeatsControl($type){
        $data = getAllSeats();
        $html = '<div class="container border border-secondary "><div class="row seats"></div>';
        $i = 54;
        while($i > 0){
            $status = $data[$i - 1]["status"];

            if($i == 54 || $i == 51){
              $html .= '<div class="row seats"><div class="col"></div><div class="col"></div><div class="col"></div><div class="col"></div>';
              $html .= '<div class="col border border-dark ">' . $i . '<br/>' . getCheckbox($status, $i) . '</div>';
              $i--;
            }else if($i % 12 == 1){
                $html .= '<div class="col border border-dark ">' . $i . '<br/>' . getCheckbox($status, $i) . '</div></div>';
                $html .= '<div class="row seats"></div>';
                $i--;
            }else if($i % 12 == 4){
                $html .= '<div class="col border border-dark ">' . $i . '<br/>' . getCheckbox($status, $i) . '</div></div>';
                if($i == 52)
                  $i--;
                else
                  $i += 5;
            }else if($i % 12 == 0 || $i % 12 == 9){
                $html .= '<div class="row seats">';
                $html .= '<div class="col border border-dark ">' . $i . '<br/>' . getCheckbox($status, $i) . '</div>';
                $i--;
            }else if($i % 12 == 7 || $i % 12 == 10){
                $html .= '<div class="col border border-dark ">' . $i . '<br/>' . getCheckbox($status, $i) . '</div>';
                $html .= '<div class="col"></div>';
                $i -= 4;
            }else{
                $html .= '<div class="col border border-dark ">' . $i . '<br/>' . getCheckbox($status, $i) . '</div>';
                $i--;
            }

        }

          return $html;
    }
    /*function displayBorder($seatNumber){
        $css = "";
        if($seatNumber <= 12 && $seatNumber >= 7 || $seatNumber <= 24 && $seatNumber >= 19 || $seatNumber <= 36 && $seatNumber >= 31 || $seatNumber <= 48 && $seatNumber >= 43)
          $css = " border-bottom border-dark";

        return $css;
    }*/

    function getCheckbox($status, $i){
        $html = '<input type="checkbox" name="unavailableSeats[]" value="' . $i . '"';
        if($status == 9){
            $html .= ' checked >';
        }else{
            $html .= '>';
        }
        return $html;
    }

    function getOccupantInfo($type, $fullName, $classInfo, $moreInfo){
        $html = "";
        if(isset($type) && $type != 0){
            $html = $fullName . '<br>' . $classInfo . $moreInfo;
        }
        return $html;
    }

    function getSeatButton($type, $status, $seatNumber){
      $html = "";
        if($type == 1){
            if($status == 0){
                $html = 'onclick="location.href=\'checkIn.php?seat=' . $seatNumber . '\'"';
            }else if($status == 1 || $status == 2){
                $html = 'onclick="location.href=\'checkOut.php?seat=' . $seatNumber . '\'"';
            }
        }
        if($type == 2){
            $html = 'onclick="location.href=\'editSeat.php?seat=' . $seatNumber . '\'"';
        }
        return $html;
    }

    function getStatusColor($status, $mode){
        $color = "";
        if($mode == 0 || $mode == 1){
            switch($status){
                case 0:
                  $color = "bg-success";
                break;
                case 1:
                case 2:
                  $color = "bg-danger";
                break;
                case 9:
                  $color = "bg-secondary";
                break;
            }
        }else if($mode == 2){
            switch($status){
                case 0:
                  $color = "bg-success";
                break;
                case 1:
                  $color = "bg-warning";
                break;
                case 2:
                  $color = "bg-info";
                break;
                case 9:
                  $color = "bg-secondary";
                break;
            }
        }

        return $color;
    }
?>
