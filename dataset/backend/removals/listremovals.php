<?php
    // clear existing files
    $files = glob('../../removals/*');
    $filenames = array();
    foreach($files as $file){ 
        if(is_file($file)) { 
            $filenames[] = basename($file);
        }
    }
    echo json_encode($filenames);
?>