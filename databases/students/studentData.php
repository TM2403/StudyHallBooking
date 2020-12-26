<?php
    ini_set('display_errors', TRUE);
    require_once(dirname(__FILE__) . "/../connect.php");

    function getStudentFromID($ID){
      $pdo = connectScannerDatabase();
      //$sql = "SELECT lastName, firstName, studentNumber, entryTime, exitTime, status FROM studentInfo INNER JOIN studentTimeRecord ON studentInfo.IDm_hash = studentTimeRecord.IDm_hash WHERE  grade = :grade AND class = :class";
      $sql = "SELECT lastName, firstName, grade, class, studentNum FROM students WHERE  studentID = :studentID";

      //$sql = "SELECT lastName, firstName, studentNumber FROM studentInfo WHERE grade = :grade AND class = :class";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":studentID", $ID);
      $stmt->execute();
      $result = $stmt->fetchAll();
      if(count($result) != 0)
          return $result[0];
      else
          return "";
    }

    function displayStudentEditor($data){
        $id = $data["id"];
        $IDm_hash = $data["IDm_hash"];
        $lastName = $data["lastName"];
        $firstName = $data["firstName"];
        $email = $data["email"];
        $grade = $data["grade"];
        $class = $data["class"];
        $studentNum = $data["studentNum"];
    }

    function displayStudentTimeRecord($grade, $class){
        $html = "";
        $data = getStudentTimeRecord($grade, $class);
      foreach($data as $person){
            //global $html;
            $html .= "<tr>";
            $html .= "<td>" . $person["firstName"] . " " . $person["lastName"] . "</td>";
            $html .= "<td>" . $person["studentNum"] . "</td>";

            if($person["status"] == 1)
                $html .= "<td class='table-info'>At School</td>";
            else
                $html .= "<td class='table-danger'>Out of School</td>";

            $html .= "<td>" . strval($person["entryTime"]) . "</td>";
            $html .= "<td>" . strval($person["exitTime"]) . "</td>";
            $html .= "</tr>";
        }

        return $html;
    }

    function getStudentList($grade, $class, $status){
      $pdo = connectScannerDatabase();
      $sql = "SELECT id, studentID, lastName, firstName, studentNum, accountStatus, message FROM studentInfo WHERE grade = :grade AND class = :class AND (accountStatus = :status1 OR accountStatus = :status2 OR accountStatus = :status3 OR accountStatus = :status4 OR accountStatus = :status5) ORDER BY studentNum";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":grade", $grade);
      $stmt->bindParam(":class", $class);

      $count = 0;
      $status1 = "-1";
      $status2 = "-1";
      $status3 = "-1";
      $status2 = "-1";
      $status3 = "-1";

      foreach($status as $option){
          switch($count){
              case 0:
                  $status1 = $option;
                  $status2 = $option;
                  $status3 = $option;
              break;
              case 1:
                  $status2 = $option;
                  $status3 = $option;
              break;
              case 2:
                  $status3 = $option;
              break;
          }
          if($option == 2){
              $status4 = 3;
          }
          if($option == 0){
              $status5 = 4;
          }
          $count++;
      }

      $stmt->bindParam(":status1", $status1);
      $stmt->bindParam(":status2", $status2);
      $stmt->bindParam(":status3", $status3);
      $stmt->bindParam(":status4", $status4);
      $stmt->bindParam(":status5", $status5);

      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }

    function displayStudentList($grade, $class, $status, $token){
        $html = "";
        $data = getStudentList($grade, $class, $status);
        foreach($data as $person){
            $html .= "<tr>";
            $html .= "<td>" . $person["firstName"] . " " . $person["lastName"] . "</td>";
            $html .= "<td>" . $person["studentNum"] . "</td>";
            $html .= "<td>" . getStringAccountStatus($person["accountStatus"]) . "</td>";
            $html .= "<td>" . $person["message"] . "</td>";
            $html .= displayStudentButton($person, $token);
            $html .= "</tr><p></p>";
        }

        return $html;
    }

    function displayStudentButton($person, $token){
        $html = "";
        $html .= "<td>";
        $html .= "<form method='POST' action='students/viewStudent.php'>";
        $html .= "<input type='hidden' name='email' value = " . $person["email"] ."><input type='hidden' name='token' value = " . $token .">";
        $html .= "<input type='submit' value='Edit' class='w-100 btn btn-success'/></form>";
        if($person["accountStatus"] == 2 || $person["accountStatus"] == 3){
            $html .= "<form method='POST' action='databases/students/approveCard.php'>";
            $html .= "<input type='hidden' name='id' value = " . $person["id"] ."><input type='hidden' name='token' value = " . $token .">";
            $html .= "<input type='submit' value='Approve IC Card' class='w-100 btn btn-info'/>";
            $html .= "</form>";
        }
        $html .= "</td>";
        return $html;
    }

    function getStringAccountStatus($status){
          $htmlStatus = "";
          switch($status){
              case 0:
                  $htmlStatus = "<p class='text-danger'>Not Yet Registered</p>";
              break;
              case 1:
                  $htmlStatus = "<p class='text-success'>Active</p>";
              break;
              case 2:
                  $htmlStatus = "<p class='text-primary'>Pending for the approval.</p>";
              break;
              case 3:
                  $htmlStatus = "<p class='text-primary'>Pending for the approval.</p>";
              break;
              case 4:
                  $htmlStatus = "<p class='text-secondary'>The account is suspended.</p>";
              break;
          }
          return $htmlStatus;
    }

    function getUnregisterdIDm(){
        $pdo = connectScannerDatabase();
        $sql = "SELECT IDm_hash, entryTime FROM studentTimeRecord WHERE status = -1 ORDER BY entryTime DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function displayUnregisteredIDm($token){
        $html = "";
        $result = getUnregisterdIDm();
        foreach($result as $person){
            $html .= "<tr>";
            $html .= "<td>" . $person["IDm_hash"] . "</td>";
            $html .= "<td>" . strval($person["entryTime"]) . "</td>";
            $html .= "<td><input type='button' onclick='window.location.replace(\"students/newStudent.php?idm=" . $person["IDm_hash"] . "\")' class='btn btn-success' value='Add Student'></td>";
            $html .= "</tr>";
        }
        return $html;
    }
?>
