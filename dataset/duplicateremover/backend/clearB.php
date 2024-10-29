<?php
    require '../../backend/dbconnection.php';

    $result = pg_query($dbconn, "DELETE FROM datasetB;");

    // clear existing files
    $files = glob('../uploads/*');
    foreach($files as $file){ 
        if (str_ends_with($file, "datasetB.csv")){
            unlink($file);
        }
    }
    
    http_response_code(200);
?>
