<?php

    
    function getToken() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.myperfit.com/v2/login");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"user\": \"USUARIO@USUARIO.COM\",
            \"password\": \"SUASENHA\"
        }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));
        
        $res = curl_exec($ch);
        $response = json_decode($res);
        
        
        curl_close($ch);
        return $response->data->token;
    }
    $token = getToken();
    $apiKey = "SEU_TOKEN";
        
        
    function getList($id, $token, $apiKey){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.myperfit.com/v2/CONTA_DA_API/lists/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Bearer ".$apiKey,
          "X-Auth-Token: ".$token
        ));
        
        $res = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($res);
        return $response->data;
    }
    
    
    function insertClient($data, $token, $apiKey){
        $data['lists'] = array(getList($data['lists'],$token, $apiKey));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.myperfit.com/v2//CONTA_DA_API/contacts");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/x-www-form-urlencoded",
          "Authorization: Bearer ".$apiKey,
          "X-Auth-Token: ".$token,
        ));
        
        
        curl_close($ch);
        
        $res = curl_exec($ch);
        $response = json_decode($res);
        print_r($response);
        
    }
    
   if(!empty($_POST)){
      insertClient($_POST, $token, $apiKey);
    }else{
        echo 'Parado ai, forasteiro! Você não tem permissões o suficiente para acessar está pagina!';
    }