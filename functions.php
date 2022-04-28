<?php 

    function getFloor($floor) {
        switch ($floor) {
            case 0:
                return "";
            case 1:
                return ":8000";
            case 2:
                return ":7259";
            default:
                return "";
        }
    }


    function getToken($id, $pwd, $floor) {
        $url = "141.95.153.155".getFloor($floor)."/inscription";
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

    function regularGet($dest, $id, $pwd, $floor) {

        $url = "141.95.153.155".getFloor($floor).$dest;
        $headers = array("X-Auth-Token: ".getToken($id, $pwd, $floor));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
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
                $html .= "<ul>";
                foreach($value as $value){
                    $html .= "<li>".$value."</li>";
                }
                $html .= "</ul>";
            }
        }
        return($html);
    }

    function getThisThing() {
        $url = "141.95.153.155";
    }

?>