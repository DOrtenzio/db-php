<?php
if(session_status()===PHP_SESSION_NONE) session_start();

if(isset($_SESSION["host"])){
    $servername = $_SESSION["host"];
    $dbname = $_SESSION["dbname"];
    $username = $_SESSION["usr"];
    $password = $_SESSION["psw"];

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} else{
    header("location: errorpage.html");
    exit();
}