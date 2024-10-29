<?php
    require '../dbconnection.php';
    require_once '../../login/jwt.php';
    require_once '../../login/authorization.php';

    // clear existing files
    $files = glob('../../exception/*');
    foreach($files as $file){ 
        if(is_file($file)) { unlink($file); }
    }

    /* Get the name of the file uploaded to Apache */
    $filename = $_FILES['file']['name'];

    /* Prepare to save the file upload to the upload folder */
    $location = "../../exception/exceptionlist.csv";

    if (str_ends_with($filename, ".csv") or str_ends_with($filename, ".txt")){
        /* Permanently save the file upload to the upload folder */
        if ($_FILES['file']['size']<99999987){
            if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 
                // Let's create a tempory table
                pg_query($dbconn, "DELETE FROM exceptiontable;");
                // pg_query($dbconn, "CREATE TABLE exceptiontable (numbertoremove VARCHAR (12) NOT NULL);");

                $files = glob("../../exception/*");
                $exceptionlist = array();
                foreach($files as $file){ 
                    if (str_ends_with($file, "exceptionlist.csv")){
                        $contents = file_get_contents($file);
                        $exceptionlist = explode("\n", $contents);
                    }
                }
                $insertableValues = [];
                foreach ($exceptionlist as $phone) {
                    $insertableValues[] = trim($phone);
                }
                $result = pg_copy_from($dbconn, "exceptiontable", $insertableValues);
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