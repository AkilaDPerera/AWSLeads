<?php
    require_once '../dbconnection.php';

    $result = pg_query($dbconn, "DELETE FROM exceptiontable;");
    // pg_query($dbconn, "CREATE TABLE exceptiontable (numbertoremove VARCHAR (12) NOT NULL);");

    // clear existing files
    $files = glob('../../exception/*');
    foreach($files as $file){ 
        if(is_file($file)) { unlink($file); }
    }

    echo $result;
    http_response_code(200);
?>
