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
    isset($_POST["thereIsDefault"]) &&
    !empty($_POST["thereIsDefault"])){

    try {
        $sql = "CREATE TABLE ".trim($_POST["nomeTabella"])." (";

        $numPk=0;
        for($i=0; $i < count($_POST["nomeCampo"]); $i++) if(isset($_POST["isPK"][$i])) $numPk++;

        if($numPk==0){
            header("location: errorpage.html");
            exit();
        }else{
            for($i=0; $i < count($_POST["nomeCampo"]); $i++){
                $nomeCampo = trim($_POST["nomeCampo"][$i]);
                
                $tipo = "";
                if($_POST["tipoCampo"][$i] == "INT") $tipo = "INT";
                elseif($_POST["tipoCampo"][$i] == "VARCHAR") $tipo = "VARCHAR(255)";
                elseif($_POST["tipoCampo"][$i] == "DATE") $tipo = "DATE";
                
                $pk = "";
                if(isset($_POST["isPK"][$i]) && $numPk==1) $pk = "PRIMARY KEY";
    
                $ai = "";
                if(isset($_POST["isAI"][$i])) $ai = "AUTO_INCREMENT";

                $null = "";
                if (isset($_POST["isNull"][$i]) && $_POST["isNull"][$i]) $null = "NOT NULL";

                $def = "";
                $thereIsDefault = $_POST["thereIsDefault"][$i] ?? 0;
                if ($thereIsDefault == 1) {
                    $value = $_POST["defaultValue"][$i] ?? '';
                    if ($value !== '') {
                        if (strtoupper($tipoCampo) === "VARCHAR") $def = "DEFAULT '" . addslashes($value) . "'";
                        else $def = "DEFAULT " . $value;
                    } else {
                        $def = (strtoupper($tipoCampo) === "VARCHAR") ? "DEFAULT ''" : "DEFAULT 0";
                    }
                } else {
                    $def = ($null === "NOT NULL") ? ((strtoupper($tipoCampo) === "VARCHAR") ? "DEFAULT ''" : "DEFAULT 0") : "DEFAULT NULL";
                }
    
                $sql .= $nomeCampo." ".$tipo." ".$ai." ".$null." ".$def." ".$pk.",";
            }
    
            if($numPk>1){
                $sql .= "PRIMARY KEY(";
                for($i=0; $i < count($_POST["nomeCampo"]); $i++) if(isset($_POST["isPK"][$i])) $sql .= $_POST["nomeCampo"][$i].",";
                $sql = rtrim($sql,",");
                $sql .= "),";
            }

            $sql = rtrim($sql,","); 
            $sql .= ")";
    
            $conn->exec($sql);
            $message = "Creata con Successo \n".$sql;
        }
    } catch(PDOException $e) {
        header("location: errorpage.html");
        exit();
    }
}else{
    header("location: errorpage.html");
    exit();
}

$conn=null;

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultato</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <p><?php echo isset($message) ? $message : ''; ?></p>
        <a href="gestione_db.php">&larr; Torna indietro</a>
    </div>
</body>
</html>