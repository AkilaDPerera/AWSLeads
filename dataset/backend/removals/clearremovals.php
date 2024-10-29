<?php
    // clear existing files
    $files = glob('../../removals/*');
    foreach($files as $file){ 
        if(is_file($file)) { unlink($file); }
    }

    http_response_code(200);
?>