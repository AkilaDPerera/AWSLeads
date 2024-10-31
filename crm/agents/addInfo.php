<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        // pg_query($dbconn, "CREATE TABLE IF NOT EXISTS information (  pk SERIAL PRIMARY KEY,   phone VARCHAR(12) NOT NULL, phone2 VARCHAR(12), email VARCHAR(50), company VARCHAR(50),  uname VARCHAR(50),   revenue VARCHAR(50),  aname VARCHAR(50), nocontact BOOLEAN, notinterested BOOLEAN, followingup BOOLEAN, listedtosale BOOLEAN, successsale BOOLEAN, possiblebuyer BOOLEAN, notes VARCHAR(500), createddate DATE NOT NULL, updateddate DATE NOT NULL, whocreatedpk VARCHAR(4), whichcompany VARCHAR(100) );");
        // appointment timestamp without time zone;

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            $success = true;
            $message = "";

            // check phone number duplicates first
            $sql_check = "SELECT pk, phone, phone2, email FROM information WHERE (phone='".trim($_POST["phone"])."' OR phone2='".trim($_POST["phone"])."') AND whichcompany='".$_POST["whichcompany"]."';";
            $result = pg_query($dbconn, $sql_check);
            $row = pg_fetch_assoc($result);
            if ($row!==false){
                $success = false;
                $message = "Duplicate phone number detected.";
            }
            
            if ($success){
                // check phone2 number duplicates
                if (trim($_POST["phone2"])!==""){
                    $sql_check = "SELECT * FROM information WHERE (phone='".trim($_POST["phone2"])."' OR phone2='".trim($_POST["phone2"])."') AND whichcompany='".$_POST["whichcompany"]."';";
                    $result = pg_query($dbconn, $sql_check);
                    $row = pg_fetch_assoc($result);
                    if ($row!==false){
                        $success = false;
                        $message = "Duplicate phone number detected.";
                    }
                }
            }
            if ($success && (trim($_POST["email"])!="")){
                // check email duplicates
                $sql_check = "SELECT * FROM information WHERE (email='".trim($_POST["email"])."') AND whichcompany='".$_POST["whichcompany"]."';";
                $result = pg_query($dbconn, $sql_check);
                $row = pg_fetch_assoc($result);
                if ($row!==false){
                    $success = false;
                    $message = "Duplicate email detected.";
                }
            }

            $appointment = "";
            if ($_POST["appointment"]!==""){
                $appointment = DateTimeImmutable::createFromFormat("Y-m-d H:i", str_replace("T", " ", $_POST["appointment"]));
                $appointment = "".($appointment->getTimestamp());
            }
            // echo (string) $appointment->getTimestamp();
            // echo date('Y-m-d H:i', $dated->getTimestamp());

            if ($success){
                // insertion
                $date = date('Y-m-d');
                $result = pg_insert($dbconn, "information", array(
                    "email" => trim($_POST["email"]),
                    "phone" => trim($_POST["phone"]),
                    "phone2" => trim($_POST["phone2"]),
                    "company" => $_POST["company"],
                    "uname" => $_POST["uname"],
                    "web" => $_POST["web"],
                    "revenue" => $_POST["revenue"],
                    "aname" => "",
                    "nocontact" => $_POST["nocontact"],
                    "notinterested" => $_POST["notinterested"],
                    "followingup" => $_POST["followingup"],
                    "listedtosale" => $_POST["listedtosale"],
                    "successsale" => $_POST["successsale"],
                    "lowrev" => $_POST["lowrev"],
                    "possibleproperty" => $_POST["possibleproperty"],
                    "possiblebuyer" => $_POST["possiblebuyer"],
                    "notes" => $_POST["notes"],
                    "createddate" => $date,
                    "updateddate" => $date,
                    "whocreatedpk" => $_POST["whocreatedpk"],
                    "whichcompany" => $_POST["whichcompany"],
                    "appointment" => $appointment
                ));
                if ($result===false){
                    $success = false;
                    $message = "Something went wrong.";
                }
            }

            if ($success){
                echo json_encode(array(
                    "success"=> true, 
                    "message"=> "Information added."
                ));
            } else {
                echo json_encode(array(
                    "success"=> false, 
                    "message"=> $message
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
    createdDate - $date = date('Y-m-d');
    updatedDate - $date = date('Y-m-d');
    whocreatedpk -
    whichcompany - 
    -->
    <!-- 
    CREATE TABLE IF NOT EXISTS information ( 
    pk SERIAL PRIMARY KEY,  
    phone VARCHAR(12),
    phone2 VARCHAR(12),
    email VARCHAR(50) NOT NULL UNIQUE,  
    company VARCHAR(50), 
    uname VARCHAR(50),  
    revenue VARCHAR(50), 
    aname VARCHAR(50),
    notinterested BOOLEAN,
    followingup BOOLEAN,
    listedtosale BOOLEAN,
    successsale BOOLEAN,
    possiblebuyer BOOLEAN,
    notes VARCHAR(500),
    createdDate DATE NOT NULL,
    updatedDate DATE NOT NULL,
    whocreatedpk VARCHAR(4),
    whichcompany VARCHAR(100),
    )
    */


?>
