<?php
    require '../../backend/dbconnection.php';

    /* Get the name of the file uploaded to Apache */
    $filename = $_FILES['fileA']['name'];

    /* Prepare to save the file upload to the upload folder */
    $location = "../uploads/datasetA.csv";

    if (str_ends_with($filename, ".csv") or str_ends_with($filename, ".txt")){
        /* Permanently save the file upload to the upload folder */
        if ($_FILES['fileA']['size']<99999987){
            if ( move_uploaded_file($_FILES['fileA']['tmp_name'], $location) ) { 

                // Let's create a tempory table
                // pg_query($dbconn, "CREATE TABLE IF NOT EXISTS datasetA (columnA VARCHAR (20) NOT NULL);");
                
                $files = glob("../uploads/*");
                $dataset = array();
                foreach($files as $file){ 
                    if (str_ends_with($file, "datasetA.csv")){
                        $contents = file_get_contents($file);
                        $dataset = explode("\n", $contents);
                    }
                }
                $insertableValues = [];
                foreach ($dataset as $phone) {
                    $phone = trim($phone);
                    $phone = str_replace(array("(",")"," ","-"),"",$phone);
                    if(isset($_POST["leadingone"])){
                        $phone = ltrim($phone, '1');
                    };
                    $insertableValues[] = $phone;
                }
                $result = pg_copy_from($dbconn, "datasetA", $insertableValues);
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