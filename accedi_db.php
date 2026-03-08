<?php
if(session_status()===PHP_SESSION_NONE) session_start();

if(isset($_POST["host"], $_POST["namedb"], $_POST["usr"], $_POST["psw"]) && !empty(trim($_POST["host"])) && !empty(trim($_POST["namedb"]))){
    $servername = trim($_POST["host"]);
    $dbname = trim($_POST["namedb"]);
    $username = trim($_POST["usr"]);
    $password = trim($_POST["psw"]);

    $_SESSION["host"] = $servername;
    $_SESSION["dbname"] = $dbname;
    $_SESSION["usr"] = $username;
    $_SESSION["psw"] = $password;
}elseif(isset($_SESSION["host"])){
    $servername = $_SESSION["host"];
    $dbname = $_SESSION["dbname"];
    $username = $_SESSION["usr"];
    $password = $_SESSION["psw"];
}else{
    echo "no1";
    //header("Location: errorpage.html");
    exit();
}

$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Errore: " . $e->getMessage();
    //header("Location: errorpage.html");
    exit();
}

if($conn){
    $conn = null;
    header("location: gestione_db.php");
}

$conn = null;
?>