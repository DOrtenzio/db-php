<?php
if(session_status()===PHP_SESSION_NONE) session_start();
require("connessione_db.php"); 

if(
    isset($_POST["nomeTabella"]) &&
    !empty($_POST["nomeTabella"]) &&
    isset($_POST["nomeCampo"]) &&
    !empty($_POST["nomeCampo"]) &&
    is_array($_POST["nomeCampo"]) &&
    isset($_POST["tipoCampo"]) &&
    !empty($_POST["tipoCampo"]) &&
    is_array($_POST["tipoCampo"]) &&
    isset($_POST["isPK"]) &&
    !empty($_POST["isPK"]) &&
    is_array($_POST["isPK"]) &&
    isset($_POST["isAI"]) &&
    !empty($_POST["isAI"]) &&
    is_array($_POST["isAI"])){

    try {
        $sql = "CREATE TABLE ".trim($_POST["nomeTabella"])." (";

        for($i=0; $i < count($_POST["nomeCampo"]); $i++){
            $nomeCampo = trim($_POST["nomeCampo"][$i]);
            
            $tipo = "";
            if($_POST["tipoCampo"][$i] == "INT") $tipo = "INT";
            elseif($_POST["tipoCampo"][$i] == "VARCHAR") $tipo = "VARCHAR(255)";
            elseif($_POST["tipoCampo"][$i] == "DATE") $tipo = "DATE";
            
            $pk = "";
            if(isset($_POST["isPK"][$i])) $pk = "PRIMARY KEY";

            $ai = "";
            if(isset($_POST["isAI"][$i])) $ai = "AUTO_INCREMENT";

            $sql .= $nomeCampo." ".$tipo." ".$ai." ".$pk.",";
        }

        $sql = rtrim($sql,","); 
        $sql .= ")";

        $conn->exec($sql);

        echo "Creata con successo";
    } catch(PDOException $e) {
        header("location: errorpage.html");
        exit();
    }
}else{
    header("location: errorpage.html");
    exit();
}

$conn=null;