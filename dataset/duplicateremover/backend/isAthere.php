<?php
    // clear existing files
    $isthere = "false"; 
    $files = glob('../uploads/*');
    foreach($files as $file){ 
        if (str_ends_with($file, "datasetA.csv")){
            $isthere = "true";
        }
    }
    echo $isthere;
?>