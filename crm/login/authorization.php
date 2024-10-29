<?php
    require_once '../backend/constant.php';
    require_once 'jwt.php';

    $jwtManager = new JwtManager($secretKey);
    $ukey = null;
    $role = null;
    $cname = null;
    $username = null;

    if (!isset($_POST["jwt"])){
        http_response_code(403);
        exit('Not authorized');
    }

    if ($jwtManager->validateToken($_POST["jwt"])) {
        $decodedPayload = $jwtManager->decodeToken($_POST["jwt"]);
        $ukey = $decodedPayload["ukey"];
        $role = $decodedPayload["role"];
        $cname = $decodedPayload["cname"];
        $username = $decodedPayload["username"];
    } else {
        http_response_code(403);
        exit('Not authorized');
    }
?>