<?php

    require_once '../constant.php';
    require_once '../../login/jwt.php';
    require_once '../../login/authorization.php';

    // clear existing files
    $files = glob('../../removals/*');
    $count = 0;
    foreach($files as $file){ $count += 1; }
    $count += 1;

    /* Get the name of the file uploaded to Apache */
    $filename = $_FILES['file']['name'];

    /* Prepare to save the file upload to the upload folder */
    $location = "../../removals/removals_".$count.".csv";

    if (str_ends_with($filename, ".csv") or str_ends_with($filename, ".txt")){
        /* Permanently save the file upload to the upload folder */
        if ($_FILES['file']['size']<99999987){
            if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 
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