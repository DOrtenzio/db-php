<?php
session_start();

if(isset( $_POST["host"] ) && empty(trim("host")) && isset( $_POST["namedb"] ) && empty(trim("namedb"))){
    //accesso diretto
    $servername = trim($_POST["host"]);
    $dbname = trim($_POST["namedb"]);
    $username = trim($_POST["usr"]);
    $password = trim($_POST["psw"]);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        header("errorpage.html");
    }

    try {
        $sql = "CREATE DATABASE "+$dbname;
        $conn->exec($sql);
        
        $_SESSION["host"] = $servername;
        $_SESSION["dbname"] = $dbname;
        $_SESSION["usr"] = $username;
        $_SESSION["psw"] = $password;
    } catch(PDOException $e) {
        header("errorpage.html");
    }

    $conn = null;
} elseif(){

} else{
    header("errorpage.html");
}
?>