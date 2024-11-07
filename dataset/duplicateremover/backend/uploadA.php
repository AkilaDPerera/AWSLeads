<?php
    require '../../backend/dbconnection.php';

    /* Get the name of the file uploaded to Apache */
    $filename = $_FILES['fileA']['name'];

    /* Prepare to save the file upload to the upload folder */
    $location = "../uploads/datasetA.csv";

    pg_set_client_encoding($dbconn, 'UTF-8');
    if (str_ends_with($filename, ".csv") or str_ends_with($filename, ".txt")){
        /* Permanently save the file upload to the upload folder */
        if ($_FILES['fileA']['size']<99999987){
            if ( move_uploaded_file($_FILES['fileA']['tmp_name'], $location) ) { 

                // Let's create a tempory table
                pg_query($dbconn, "CREATE TABLE IF NOT EXISTS datasetA (columnA VARCHAR (20) NOT NULL, columnB VARCHAR (100));");
                
                $files = glob("../uploads/*");
                $insertableValues = array();
                foreach($files as $file){ 
                    if (str_ends_with($file, "datasetA.csv")){
                        if (($handle = fopen($file, "r")) !== FALSE) {
                            $lineNumber = 0;
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $lineNumber++;if ($lineNumber == 1) { continue; }

                                $phone = trim($data[0]);
                                $phone = str_replace(array("(",")"," ","-"),"",$phone);
                                if (strlen($phone)!=10){ continue; }

                                $cname = str_replace("\t","",$data[1]);
                                $cname = substr($cname, 0, 99);
                                
                                $insertableValues[] = mb_convert_encoding($phone."\t".$cname, "UTF-8", "auto");
                            }
                            fclose($handle);
                        }
                    }
                }
                pg_copy_from($dbconn, "datasetA", $insertableValues, "\t");
                pg_query($dbconn, "WITH DuplicateRecords AS (SELECT ctid, ROW_NUMBER() OVER (PARTITION BY columna ORDER BY ctid) AS row_num FROM dataseta) DELETE FROM dataseta WHERE ctid IN (SELECT ctid FROM DuplicateRecords WHERE row_num > 1);");
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