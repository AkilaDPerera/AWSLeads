<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        if ($_POST["ukey"]=="1"){
            if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
                $success = true;
                $message = "";
                
                $sql_query = "SELECT * FROM users WHERE urole!='superadmin' ORDER BY username;";
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
                        "message"=> "No users found."
                    ));
                } else {
                    echo json_encode(array(
                        "success"=> true, 
                        "message"=> "200",
                        "count" => $count,
                        "data" => $data
                    ));
                }
            }
        } else {
            echo json_encode(array(
                "success"=> false, 
                "message"=> "Unauthorized request."
            ));
        }
    }
?>
