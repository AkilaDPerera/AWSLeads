<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            $success = true;
            $message = "";
            $data = array();

            if (trim($_POST["phone"])===""){
                // email only
                $sql_query = "SELECT * FROM information WHERE whichcompany='".$_POST["whichcompany"]."' AND email='".trim($_POST["email"])."';";
            } else {
                if (trim($_POST["email"])===""){
                    // phone only
                    $sql_query = "SELECT * FROM information WHERE whichcompany='".$_POST["whichcompany"]."' AND (phone='".trim($_POST["phone"])."' OR phone2='".trim($_POST["phone"])."');";
                } else {
                    // phone and email
                    $sql_query = "SELECT * FROM information WHERE whichcompany='".$_POST["whichcompany"]."' AND (phone='".trim($_POST["phone"])."' OR phone2='".trim($_POST["phone"])."' OR email='".trim($_POST["email"])."');";
                }
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

    /*
    email
    phone
    phone2
    company
    uname
    revenue
    aname
    notinterested
    followingup
    listedtosale
    successsale
    possiblebuyer
    notes
    createdDate
    updatedDate
    whocreatedpk
    whichcompany
    */

?>
