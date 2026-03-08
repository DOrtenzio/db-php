<?php
if(session_status()===PHP_SESSION_NONE) session_start();
require("connessione_db.php"); //controllo
$conn=null;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Tabelle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="crea_table.php" method="POST">
        <p>Crea una Nuova Tabella in:<?php echo $_SESSION["dbname"]; ?></p>
        <button type="button" onclick="aggiungiCampo()">+ Campo</button>
        <input type="text" name="nomeTabella" placeholder="nomeTabella">
        <div id="campiTable">
        </div>
        <input type="submit" name="Crea Tabella" value="Crea Tabella">
        <input type="reset" name="Annulla" value="Annulla">
    </form>

    <template>
        <div class="campoNuovo">
            <input class="nomeCampo" type="text" name="nomeCampo[]" placeholder="nome_del_campo" required>
            <select class="tipoCampo" name="tipoCampo[]" required>
                <option value="INT">INT</option>
                <option value="VARCHAR">VARCHAR</option>
                <option value="DATE">DATE</option>
            </select> 
            <input class="isPK" type="checkbox" name="isPK[]" >E' PK?
            <input class="isAI" type="checkbox" name="isAI[]" >E' Auto Incrementato?
            <button>X</button>
        </div>
    </template>

    <script>
        function aggiungiCampo(){
            const template = document.querySelector("template");
            const clone = template.content.cloneNode(true);
            const btnRemove = clone.querySelector("button");
            btnRemove.onclick = function(){
                this.parentElement.remove();
            };
            document.getElementById("campiTable").appendChild(clone);
        }
    </script>
</body>
</html>