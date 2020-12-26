<?php
    function connectLoginDatabase(){
        $srvdsn = 'mysql:host=localhost;dbname=SelfStudy;port=3306;';
        $srvuser = 'root';
        $srvpass = "2CuD5aXWkGp5uudQ";
        $pdo = new PDO($srvdsn, $srvuser, $srvpass);
        return $pdo;
    }

    function connectScannerDatabase(){
        $scannerServer = 'mysql:host=localhost;dbname=SelfStudy;port=3306;charset=utf8';
        $scannerUser = 'root';
        $scannerPass = "2CuD5aXWkGp5uudQ";
        $pdo = new PDO($scannerServer, $scannerUser, $scannerPass);
        return $pdo;
    }
?>
