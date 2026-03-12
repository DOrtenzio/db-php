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
} elseif(isset($_SESSION["host"])){
    $servername = $_SESSION["host"];
    $dbname = $_SESSION["dbname"];
    $username = $_SESSION["usr"];
    $password = $_SESSION["psw"];
} else {
    ?>
    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Errore accesso</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div>
            <p>Dati di accesso mancanti</p>
            <a href="index.html">&larr; Torna alla pagina iniziale</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

$conn = null;

try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $errorText = $e->getMessage();
        ?>
        <!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
            <title>Errore connessione</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div>
                <p>Errore: <?php echo htmlspecialchars($errorText); ?></p>
                <a href="index.html">&larr; Torna alla pagina iniziale</a>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
if($conn){
    $conn = null;
    header("location: gestione_db.php");
}

$conn = null;
?>