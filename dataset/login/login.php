<?php
    require_once '../backend/dbconnection.php';
    require_once 'jwt.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        pg_query($dbconn, "CREATE TABLE IF NOT EXISTS users (pk SERIAL PRIMARY KEY, username VARCHAR(30) NOT NULL UNIQUE, upassword VARCHAR(30) NOT NULL, urole VARCHAR(10) NOT NULL, cname VARCHAR(100) NOT NULL);");

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "data.leadz101.com")!==false){
            $sql_user = "SELECT pk, username, upassword, urole, cname FROM users WHERE username='".$_POST["username"]."' AND upassword='".$_POST["password"]."'";
            $result = pg_query($dbconn, $sql_user);
            $row = pg_fetch_assoc($result);
            if ($row!=null){ 
                $jwtManager = new JwtManager($secretKey);
                echo json_encode(array(
                    "success"=> true, 
                    "message"=> "User found.",
                    "role"=> $row["urole"],
                    "ukey"=> $row["pk"],
                    "cname"=> $row["cname"],
                    "jwt"=> $jwtManager->createToken(array(
                        "ukey" => $row["pk"],
                        "role"=> $row["urole"],
                        "cname"=> $row["cname"],
                        "username"=> $row["username"],
                    ))
                ));
            } else {
                echo json_encode(array(
                    "success"=> false, 
                    "message"=> "User does not exist."
                ));
            }
        } else {
            echo json_encode(array(
                "success"=> false, 
                "message"=> "Third-party request ignored.",
                "origin"=> $_SERVER['HTTP_ORIGIN']
            ));
        }
    }
?>
