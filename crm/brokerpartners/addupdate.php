<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            $success = true;
            $message = "";

            if ($_POST["pk"]===""){
                // add
                $result = pg_insert($dbconn, "users", array(
                    "username" => $_POST["username"],
                    "upassword" => $_POST["password"],
                    "urole" => $_POST["role"],
                    "cname" => $_POST["company"]
                ));
                if ($result===false){
                    $success = false;
                    $message = "Something went wrong.";
                } else {
                    $success = true;
                    $message = "Added.";
                }
            } else {
                // update
                $updatesArray = array(
                    "username" => $_POST["username"],
                    "upassword" => $_POST["password"],
                    "urole" => $_POST["role"],
                    "cname" => $_POST["company"]
                );
                $result = pg_update($dbconn, "users", $updatesArray, array(
                    "pk" => trim($_POST["pk"])
                ));
                if ($result===false){
                    $success = false;
                    $message = "Something went wrong.";
                } else {
                    $success = true;
                    $message = "Updated.";
                }
            }
            echo json_encode(array(
                "success"=> $success, 
                "message"=> $message
            ));
        }
    }
?>
