<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            $success = true;
            $message = "";

            // delete
            $result = pg_delete($dbconn, "users", array(
                "pk" => trim($_POST["pk"])
            ));
            if ($result===false){
                $success = false;
                $message = "Something went wrong.";
            } else {
                $success = true;
                $message = "Deleted.";
            }
            
            echo json_encode(array(
                "success"=> $success, 
                "message"=> $message
            ));
        }
    }
?>
