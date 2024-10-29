<?php
    // dependencies -- 
    // constant.php
    // jwt.php
    
    $jwtManager = new JwtManager($secretKey);
    $ukey = null;
    $role = null;
    $cname = null;
    $username = null;

    if (!isset($_POST["jwt"])){
        http_response_code(403);
        exit('Not authorized 1');
    }

    if ($jwtManager->validateToken($_POST["jwt"])) {
        $decodedPayload = $jwtManager->decodeToken($_POST["jwt"]);
        $ukey = $decodedPayload["ukey"];
        $role = $decodedPayload["role"];
        $cname = $decodedPayload["cname"];
        $username = $decodedPayload["username"];
        if ($decodedPayload["role"]!="superadmin"){
            http_response_code(403);
            exit('Not authorized 2');
        }
    } else {
        http_response_code(403);
        exit('Not authorized 3');
    }
?>