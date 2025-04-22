<?php
    require_once '../backend/dbconnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "../login/authorization.php";

        if (strpos($_SERVER['HTTP_ORIGIN'], "localhost")!==false || strpos($_SERVER['HTTP_ORIGIN'], "crm.leadz101.com")!==false){
            $success = true;
            $message = "";
            $date = date('Y-m-d');

            $filename = './example.txt';
            $file = fopen($filename, 'w');
            if ($file) {
                fwrite($file, $_POST["appointment"]); 
                fclose($file); 
            } 

            $appointment = "";
            if ($_POST["appointment"]!==""){
                $appointment = DateTimeImmutable::createFromFormat("Y-m-d H:i", str_replace("T", " ", $_POST["appointment"]));
                $appointment = "".($appointment->getTimestamp());
            }

            $updatesArray = array(
                "company" => $_POST["company"],
                "uname" => $_POST["uname"],
                "web" => $_POST["web"],
                "address" => $_POST["address"],
                "revenue" => $_POST["revenue"],
                "aname" => "",
                "nocontact" => $_POST["nocontact"],
                "notinterested" => $_POST["notinterested"],
                "followingup" => $_POST["followingup"],
                "listedtosale" => $_POST["listedtosale"],
                "successsale" => $_POST["successsale"],
                "lowrev" => $_POST["lowrev"],
                "na1" => $_POST["na1"],
                "na2" => $_POST["na2"],
                "possibleproperty" => $_POST["possibleproperty"],
                "possiblebuyer" => $_POST["possiblebuyer"],
                "notes" => $_POST["notes"],
                "updateddate" => $date,
                "appointment" => $appointment
            );

            if (isset($_POST['whocreatedpk'])) {
                if ($_POST['whocreatedpk']!=""){
                    $updatesArray['whocreatedpk'] = $_POST['whocreatedpk'];
                }
            }
            if (isset($_POST['whichcompany'])) {
                if ($_POST['whichcompany']!=""){
                    $updatesArray['whichcompany'] = $_POST['whichcompany'];
                }
            }

            if ($_POST["notinterested"]=="true"){
                $updatesArray['whocreatedpk'] = "34";
                $updatesArray['whichcompany'] = "Not Interested";
            }

            // check phone number duplicates first
            if (trim($_POST["phone"])!==trim($_POST["oldphone"])){
                $sql_check = "SELECT pk, phone, phone2, email FROM information WHERE (phone='".trim($_POST["phone"])."' OR phone2='".trim($_POST["phone"])."') AND whichcompany='".$_POST["whichcompany"]."';";
                $result = pg_query($dbconn, $sql_check);
                $row = pg_fetch_assoc($result);
                if ($row!==false){
                    $success = false;
                    $message = "Duplicate phone number detected.";
                } else {
                    $updatesArray["phone"] = trim($_POST["phone"]);
                }
            }
            
            if (trim($_POST["phone2"])!==trim($_POST["oldphone2"])){
                if ($success){
                    // check phone2 number duplicates
                    if (trim($_POST["phone2"])!==""){
                        $sql_check = "SELECT * FROM information WHERE (phone='".trim($_POST["phone2"])."' OR phone2='".trim($_POST["phone2"])."') AND whichcompany='".$_POST["whichcompany"]."';";
                        $result = pg_query($dbconn, $sql_check);
                        $row = pg_fetch_assoc($result);
                        if ($row!==false){
                            $success = false;
                            $message = "Duplicate phone number detected.";
                        } else {
                            $updatesArray["phone2"] = trim($_POST["phone2"]);
                        }
                    }
                }
            }
            if (trim($_POST["email"])!==trim($_POST["oldemail"])){
                if ($success){
                    if (trim($_POST["email"])!=""){
                        // check email duplicates
                        $sql_check = "SELECT * FROM information WHERE (email='".trim($_POST["email"])."') AND whichcompany='".$_POST["whichcompany"]."';";
                        $result = pg_query($dbconn, $sql_check);
                        $row = pg_fetch_assoc($result);
                        if ($row!==false){
                            $success = false;
                            $message = "Duplicate email detected.";
                        } else {
                            $updatesArray["email"] = trim($_POST["email"]);
                        }
                    } else {
                        $updatesArray["email"] = trim($_POST["email"]);
                    }
                }
            }

            if ($success){
                // update
                $result = pg_update($dbconn, "information", $updatesArray, array(
                    "pk" => trim($_POST["pk"])
                ));
                if ($result===false){
                    $success = false;
                    $message = "Something went wrong.";
                }
            }

            if ($success){
                echo json_encode(array(
                    "success"=> true, 
                    "message"=> "Information updated."
                ));
            } else {
                echo json_encode(array(
                    "success"=> false, 
                    "message"=> $message
                ));
            }
        }
    }
?>
