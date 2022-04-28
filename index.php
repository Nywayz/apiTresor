<html>
<link rel="stylesheet" href="reset.css">
<link rel="stylesheet" href="styles.css">
<?php 
include "functions.php";


 ?><form action="index.php" method="GET">
    <div id="haut">
        <div class="header">Paramètres :</div> 
        <div id="haut-contenu">
            <div>Identifiant : <input name="pseudo" value="<?php echo getPseudo() ?>"></div>
            <div>Mot de passe : <input name="password" value="<?php echo getPassword() ?>"></div>
            <div>Etage : 
                <select name="port" id="portForm" onchange="checkPort()" >
                    <option <?php if(getFloor() == "") {echo "selected";} ?> value="">0</option>
                    <option <?php if(getFloor() == ":8000") {echo "selected";} ?> value="8000">1</option>
                    <option <?php if(getFloor() == ":7259") {echo "selected";} ?> value="7259">2</option>
                </select>
            </div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div id="milieu">
        <div id="gauche">
            <div class="header">Créateur de requête :</div> 
            <div id="gauche-contenu">
                <select name="method" id="method">
                    <option <?php if(getMethod() == "GET") {echo "selected";}?> value="GET">GET</option>
                    <option <?php if(getMethod() == "POST") {echo "selected";}?> value="POST">POST</option>
                    <option <?php if(getMethod() == "PUT") {echo "selected";}?> value="PUT">PUT</option>
                    <option <?php if(getMethod() == "DELETE") {echo "selected";}?> value="DELETE">DELETE</option>
                </select>
                <div id="port"></div>
                <input name="url" id="urlInput" value="<?php echo getUrl() ?>" onkeydown="enter(this.value)">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" id="boutonEntree" value="↩">
            </div>
        </div>
        <div id="droite">
            <div class="header">Réponse :</div> 
            <div id="droite-contenu">
                <div id="oldRequest"><?php echo(getRequest())?></div><br/><br/>
                <?php echo(regularGet());?>
            </div>
        </div>
    </div>
    <div id="bas">
        <div id="bas-gauche">
            <div class="header">Notes :</div> 
            <div id="bas-gauche-contenu"><?php echo getComment() ?></div>
        </div>
        <div id="bas-droite">
            <div class="header">Coffres :</div>
            <div id="bas-droite-contenu"><?php echo getScore() ?></div>
        </div>
    </div>
</form>
</html>

<script>
    function checkPort() {
        switch(document.getElementById("portForm").value){
            case "8000":
                document.getElementById("port").innerHTML = "141.95.153.155:8000/"
            break;
            case "7259":
                document.getElementById("port").innerHTML = "141.95.153.155:7259/"
            break;
            default:
                document.getElementById("port").innerHTML = "141.95.153.155/"
            break;
        }
    }
    checkPort()

    let check = "s"

    function enter(value) {
        if (check == value){
            document.getElementById("boutonEntree").click
            console.log("dd")
        }
        check = value
    }

    function setFocus() {
        document.getElementById("urlInput").focus()
    }
    setFocus()
</script>

