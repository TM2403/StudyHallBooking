<?php
    ini_set('display_errors', TRUE);
    require_once(dirname(__FILE__) . "/../connect.php");
    require_once(dirname(__FILE__) . "/../auth/auth.php");
    //Anti CSRF
    if($_POST["token"] != $_SESSION["token"]){
        header("Location: ../../students.php");
    }
    $_SESSION["token"] = "";

    $fileType = strtolower(pathinfo(basename($_FILES["studentData"]["name"]),PATHINFO_EXTENSION));
    if($fileType != "csv"){
        header("Location: ../../students.php");
        exit(1);
    }
    $targetFile = "uploadedCSV/" . bin2hex(openssl_random_pseudo_bytes(32)) . ".csv";
    if (move_uploaded_file($_FILES["studentData"]["tmp_name"], $targetFile)) {
          UpdateStudentData($targetFile);
          unlink($targetFile);
          header("Location: ../../students.php?status=success");
      } else {
          header("Location: ../../students.php?status=fail");
    }

    function UpdateStudentData($targetFile){
        $dataFile = fopen($targetFile, "r");
        $pdo = connectScannerDatabase();
        while($student = fgetcsv($dataFile)){
          //var_dump($student);
          $sql = "INSERT INTO students(studentID, email, lastName, firstName, grade, class, studentNum) VALUES (:studentID, :email, :lastName, :firstName, :grade, :class, :studentNum) ON DUPLICATE KEY UPDATE email = :email2, lastName = :lastName2, firstName = :firstName2, grade = :grade2, class = :class2, studentNum = :studentNum2";
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(":studentID", $student[0]);
          $stmt->bindParam(":email", $student[3]);
          $stmt->bindParam(":lastName", $student[1]);
          $stmt->bindParam(":firstName", $student[2]);
          $stmt->bindParam(":grade", $student[4]);
          $stmt->bindParam(":class", $student[5]);
          $stmt->bindParam(":studentNum", $student[6]);
          $stmt->bindParam(":email2", $student[3]);
          $stmt->bindParam(":lastName2", $student[1]);
          $stmt->bindParam(":firstName2", $student[2]);
          $stmt->bindParam(":grade2", $student[4]);
          $stmt->bindParam(":class2", $student[5]);
          $stmt->bindParam(":studentNum2", $student[6]);
          $stmt->execute();
        }
        fclose($dataFile);
    }
?>
