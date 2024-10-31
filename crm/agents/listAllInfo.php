<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        // pg_query($dbconn, "CREATE TABLE IF NOT EXISTS information (  pk SERIAL PRIMARY KEY,   phone VARCHAR(12) NOT NULL, phone2 VARCHAR(12), email VARCHAR(50),   company VARCHAR(50),  uname VARCHAR(50),   revenue VARCHAR(50),  aname VARCHAR(50), nocontact BOOLEAN, notinterested BOOLEAN, followingup BOOLEAN, listedtosale BOOLEAN, successsale BOOLEAN, possiblebuyer BOOLEAN, notes VARCHAR(500), createddate DATE NOT NULL, updateddate DATE NOT NULL, whocreatedpk VARCHAR(4), whichcompany VARCHAR(100) );");

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            $success = true;
            $message = "";
            $data = array();

            if ($_POST["ukey"]=="1"){
                $sql_query = "SELECT * FROM information;";
            }else{
                $sql_query = "SELECT * FROM information WHERE whichcompany='".trim($_POST["whichcompany"])."';";
            }
            $result = pg_query($dbconn, $sql_query);

            $count = 0;
            $data = array();
            while ($row = pg_fetch_assoc($result)){
                if ($row["appointment"]!=""){
                    $row["appointment"] = date('Y-m-d H:i', $row["appointment"]);
                } else {
                    $row["appointment"] = "";
                }
                $data[] = $row;
                $count += 1;
            }

            if ($count==0){
                echo json_encode(array(
                    "success"=> false, 
                    "message"=> "No matching leads found"
                ));
            } else {
                echo json_encode(array(
                    "success"=> true, 
                    "message"=> "Matching leads found",
                    "count" => $count,
                    "data" => $data
                ));
            }
        }
    }
?>
