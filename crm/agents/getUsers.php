<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            if ($_POST["ukey"]=="1"){
                $sql_query = "SELECT pk, username, urole, cname FROM users WHERE urole != 'superadmin';";
            } else {
                $sql_query = "SELECT pk, username, urole, cname FROM users WHERE cname='".trim($_POST["whichcompany"])."';";
            }
            $result = pg_query($dbconn, $sql_query);

            $count = 0;
            $data = array();
            while ($row = pg_fetch_assoc($result)){
                $data[] = $row;
                $count += 1;
            }

            if ($count==0){
                echo json_encode(array(
                    "success"=> false, 
                    "message"=> "No matching users found"
                ));
            } else {
                echo json_encode(array(
                    "success"=> true, 
                    "message"=> "Matching users found",
                    "count" => $count,
                    "data" => $data
                ));
            }
        }
    }
?>
