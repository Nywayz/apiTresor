<?php 

    function getPseudo() {
        if(isset($_GET["pseudo"])){
            return $_GET["pseudo"];
        }
    }

    function getMethod() {
        if(isset($_GET["method"])){
            return $_GET["method"];
        }
        else return "GET";
    }

    function getPassword() {
        if(isset($_GET["password"])){
            return $_GET["password"];
        }
    }

    function getUrl() {
        if(isset($_GET["url"])){
            return $_GET["url"];
        }
    }

    function getFloor() {
        if(isset($_GET["port"])){
            switch ($_GET["port"]) {
                case 8000:
                    return ":8000";
                case 7259:
                    return ":7259";
                default:
                    return "";
            }
        }
    }

    function getRequest() {
        return  getMethod()." 141.95.153.155".getFloor()."/".getUrl();
    }


    function getToken() {
        $id = getPseudo();
        $pwd = getPassword();
        
        $url = "141.95.153.155".getFloor()."/inscription";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERPWD, "$id:$pwd");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $token = substr( $response , 60 , 40 );
        curl_close($ch);
        return $token;
    }

    function parseHTML($text, $node) {
        $node .= "<p>".$text."</p>";
        return $node;
    }

    function regularGet() {

        $dest = "/".getUrl();
        $id = getPseudo();
        $pwd = getPassword();

        $url = "141.95.153.155".getFloor().$dest;
        $headers = array("X-Auth-Token: ".getToken());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, getMethod());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "idempotent"); 
        curl_setopt($ch, CURLOPT_USERPWD, "$id:$pwd");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        if(is_null(json_decode($response))){
            $values = [$response];
        }
        else {
            if(gettype(json_decode($response, true)) == "array"){
                $values = array_values(json_decode($response, true));
            }
            else {
                $values = $response;
            }
        }
        $html = "";
        foreach ($values as $value){
            if(is_string($value)){
                $html .= "<p>".$value."</p><br/>";
            }
            if(is_array(($value))){
                $html .= '<ul>';
                foreach($value as $value){
                    $html .= "<li>".$value."</li>";
                }
                $html .= "</ul>";
            }
        }
        return($html);
    }

    function getScore() {
        $id = getPseudo();
        $pwd = getPassword();

        $url = "141.95.153.155".getFloor()."/reset";
        $headers = array("X-Auth-Token: ".getToken());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        $html = "";
        $html .= '<ul class="petit-texte">';
        foreach(array_values(json_decode($response, true))[2] as $value){
            $html .= "<li>".$value."</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    function getThisThing() {
        $url = "141.95.153.155";
    }

    function getSub() {
        $fusion = getUrl();
        switch($fusion) {
            case "inscription";
                return '<p>Header de r??ponse : "x-header-token : '.getToken().'"</p>';
        }
    }

    function getOptions() {
        $dest = "/".getUrl();

        $url = "141.95.153.155".getFloor().$dest;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $headers = array("X-Auth-Token: ".getToken());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "OPTIONS");
        $response = curl_exec($ch);
        curl_close($ch);
        $html = "";
        foreach(array_values(json_decode($response, true))[0] as $value){
            $html .= " ".$value;
        }
        return $html;
    }

    function getComment() {
        $fusion = getFloor();
        $fusion .= getUrl();
        switch($fusion){
            case "inscription":
                return "L'identifiant et le mot de passe doivent ??tre rentr??s dans les headers qui seront encod?? en base64 avant d'??tre communiqu??s au serveur. <br/><br/> Le header de r??ponse contient un token qui permet de s'identifier par la suite plus simplement. <br/><br/> Sur cette interface tout est fait automatiquement en fond mais un token diff??rent est distribu?? ?? chaque ??tage !";
            break;
            case "reset":
                return "L'??cran des scores ainsi que la date de d??but sont ici.<br/><br/> Pour plus de simplicit?? les coffres seront ??galements indiqu??s en bas ?? droite via un appel ?? cette route en parall??le !";
            break;
            case "escalier":
                return "Chaque ??tage r??pond ?? un port diff??rent et on d??couvre le suivant ici. <br/><br/> Pour simplifier le syst??me, l'interface permet de changer le port en fonction de l'??tage auquel on souhaite acc??der.";
            break;
            case "coffre":
                return "Ce message est cod?? en AES pour Advanced Encryption Standard, un mode d'encryption tr??s utilis?? et recconu.<br/><br/> Il serait utilis?? par de nombreuses institutions et entreprises dont Apple et le FBI. <br/><br/> L'encodage se fait via une cl?? qui agit comme un mot de passe et il est n??cessaire pour d??coder le message. <br/><br/> L'inventeur de REST est Roy Fielding et son nom est le mot de passe qui permet de d??couvrir la route /36 qui donne acc??s ?? un nouveau coffre !";
            break;
            case "36":
                return "Bien jou?? !";
            break;
            case "premier":
                return "Un premier coffre simple ?? trouver.<br/><br/>Bien jou?? tout de m??me !";
            break;
            case "tresor":
                return "Et pas ceux de Kellogg's !";
            break;

            case ":8000":
                return "Le second ??tage et sa carte<br/><br/> Attention tout de m??me puisqu'ici il faudra utiliser deux nouvelles m??thodes POST et PUT qui permettent habituellement toutes deux d'entrer des donn??es en base avec une particularit??...";
            break;
            case ":8000inscription":
                return "Pareil qu'au premier ??tage, la connexion s'effectue en fond via des requ??tes et des r??cup??rations de headers sans qu'il n'y ait besoin d'y toucher. Le token de cet ??tage est diff??rent mais permet la m??me chose.";
            break;
            case ":8000reset":
                return "C'est la m??me chose, mais en plus haut (les API ont-elles vraiment des ??tages ?) !";
            break;
            case ":8000escalier":
                return "Chaque ??tage r??pond ?? un port diff??rent et on d??couvre le suivant ici. <br/><br/> Pour simplifier le syst??me, l'interface permet de changer le port en fonction de l'??tage auquel on souhaite acc??der.";
            break;
            case ":8000vieux":
                return 'Ce vieil homme est un sage... En effet il existe une diff??rence fondamentale entre POST et PUT est celle-ci est que PUT est une m??thode idempotente !<br/><br/> Ce mot signifie que quoiqu\'il arrive, une requ??te PUT cherchera ?? faire la m??me chose. <br/> En entrant le mot "idempotent" avec une requ??te POST qui elle cr??e des enfants ?? chaque appel, on obtient un coffre !<br/><br/>Mais que se passe-t-il si l\'on essaie une nouvelle fois ? Eh bien un coffre apparait encore ! <br/>Au passage la requ??te PUT remplace une donn??e si elle est d??j?? existante et ce ?? l\'infini !';
            break;
            case ":8000note":
                return "C'??tait simple et juste sous notre nez mais au premier ??tage (au port par d??faut) se trouve un coffre au... /tresor !";
            break;
            case ":8000couloir":
                return "Nous ne sommes pas oblig??s de nous limiter ?? /couloir. En allant plus loin vers /couloir/1...";
            break;
            case ":8000couloir/1":
                return "...nous nous retrouvons en effet sur un coffre !";
            break;

            case ":7259":
                return "Le dernier ??tage avec un... dragon ?!<br/><br/> Une derni??re m??thode est disponible sur l'interface, vous souvenez-vous de laquelle ?";
            break;case ":7259dragon":
                return "Encore un conseil avis??. Mais que se passerait-il si nous utilisions la m??thode DELETE ?<br/><br/> Cette m??thode comme son nom l'indique sert ?? supprimer des ressources ou... des dragons.<br/><br/> En utilisant le verbe OPTIONS, on peut voir que l'utilisation de DELETE est en effet possible pour trouver le dernier coffre";
            break;


            default:
                return "Ici rien de tr??s compliqu??.<br/><br/> Une carte des routes (?? mettre dans l'url) et des explications ! A gauche vous avez le cr??ateur de requ??te sur l'interface et ?? droite la requ??te envoy??e ainsi que sa r??ponse.<br/><br/> Seule la m??thode GET est utilis??e ?? cet ??tage. Elle permet le plus souvent de r??cup??rer une donn??e, d'obtenir une r??ponse sans action sur la base (hors connexion potentielle).";
            break;
        }
    }

?>