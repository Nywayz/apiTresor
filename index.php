<html>
<link rel="stylesheet" href="reset.css">
<link rel="stylesheet" href="styles.css">
<?php 
include "text.php";
include "functions.php";

$url = "141.95.153.155";
$username = "Mac";
$password = "Le";
$firstFloor = "a3ede5167386f919fb25f74ed2920cc3d0e647f8";
$secondFloor = "fbd63e4bf6234541c5f03cdced9ca63e1ee53d94";
$thirdFloor = "4155d4fd83965db86a5c328c81e8a86244212724";


 ?>
    <div id="haut">
        <div class="header">Headers :</div> 
        <div id="haut-contenu">
            <div>Identifiant : <input></div>
            <div>Mot de passe : <input></div>
            <div>Etage : 
                <select id="portForm" onchange="checkPort()" >
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div id="milieu">
        <div id="gauche">
            <div class="header">Requête :</div> 
            <div id="gauche-contenu">
                <div id="port"></div>
                <input id="urlInput">
            </div>
        </div>
        <div id="droite">
            <div class="header">Réponse :</div> 
            <div id="droite-contenu"><?php echo(regularGet("/escalier", $username, $password, 1));?></div>
        </div>
    </div>
    <div id="bas">
        <div class="header">Commentaire :</div> 
    </div>
</html>

<script>
    function checkPort() {
        switch(document.getElementById("portForm").value){
            case "1":
                document.getElementById("port").innerHTML = "141.95.153.155:8000/"
            break;
            case "2":
                document.getElementById("port").innerHTML = "141.95.153.155:7259/"
            break;
            default:
                document.getElementById("port").innerHTML = "141.95.153.155/"
            break;
        }
    }
    checkPort()
</script>

