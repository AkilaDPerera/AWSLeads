<?php
    // clear existing files
    $isthere = "false"; 
    $files = glob('../../exception/*');
    foreach($files as $file){ 
        if (str_ends_with($file, "exceptionlist.csv")){
            $isthere = "true";
        }
    }
    echo $isthere;
?>