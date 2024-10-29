<?php
    require '../../backend/dbconnection.php';

    $result = pg_query($dbconn, "DELETE FROM datasetA;");

    // clear existing files
    $files = glob('../uploads/*');
    foreach($files as $file){ 
        if (str_ends_with($file, "datasetA.csv")){
            unlink($file);
        }
    }
    
    http_response_code(200);
?>
