<?php
    require '../../backend/dbconnection.php';

    /* Get the name of the file uploaded to Apache */
    $filename = $_FILES['fileB']['name'];

    /* Prepare to save the file upload to the upload folder */
    $location = "../uploads/datasetB.csv";

    if (str_ends_with($filename, ".csv") or str_ends_with($filename, ".txt")){
        /* Permanently save the file upload to the upload folder */
        if ($_FILES['fileB']['size']<99999987){
            if ( move_uploaded_file($_FILES['fileB']['tmp_name'], $location) ) { 

                // Let's create a tempory table
                pg_query($dbconn, "CREATE TABLE IF NOT EXISTS datasetB (columnC VARCHAR (20) NOT NULL);");
                
                $files = glob("../uploads/*");
                $insertableValues = array();
                foreach($files as $file){ 
                    if (str_ends_with($file, "datasetB.csv")){
                        if (($handle = fopen($file, "r")) !== FALSE) {
                            $lineNumber = 0;
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $lineNumber++;if ($lineNumber == 1) { continue; }
                                $phone = trim($data[0]);
                                $phone = str_replace(array("(",")"," ","-"),"",$phone);
                                if (strlen($phone)==11){ $phone = ltrim($phone, '1'); }
                                if (strlen($phone)!=10){ continue; }
                                $insertableValues[] = $phone;
                            }
                            fclose($handle);
                        }
                    }
                }
                pg_copy_from($dbconn, "datasetB", $insertableValues);
                http_response_code(201);
            } else { 
                http_response_code(400);
            }
        } else {
            http_response_code(400); 
        }
    } else {
        http_response_code(400);
    };
?>