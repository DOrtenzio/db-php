<?php
if(session_status()===PHP_SESSION_NONE) session_start();

if(isset( $_POST["host"] ) && !empty(trim($_POST["host"])) && isset( $_POST["namedb"] ) && !empty(trim($_POST["namedb"])) && isset( $_POST["usr"] ) && !empty(trim($_POST["usr"])) && isset( $_POST["psw"])){
    $servername = trim($_POST["host"]);
    $dbname = trim($_POST["namedb"]);
    $username = trim($_POST["usr"]);
    $password = trim($_POST["psw"]);

    try {
        $conn = new PDO("mysql:host=$servername", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        header("location: errorpage.html");
        exit();
    }

    try {
        $sql = "CREATE DATABASE IF NOT EXISTS ".$dbname;
        $conn->exec($sql);
        
        $_SESSION["host"] = $servername;
        $_SESSION["dbname"] = $dbname;
        $_SESSION["usr"] = $username;
        $_SESSION["psw"] = $password;

    } catch(PDOException $e) {
        header("location: errorpage.html");
        exit();
    }

    $conn = null;

    header("location: accedi_db.php");
}else{
    header("location: errorpage.html");
    exit();
}
?>