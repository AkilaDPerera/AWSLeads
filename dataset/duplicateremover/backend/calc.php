<?php
    require '../../backend/dbconnection.php';

    $sql = 'SELECT columna FROM datasetA A LEFT JOIN datasetB B ON A.columnA = B.columnB WHERE B.columnB IS NULL;';
    $f=fopen('../result/result.csv','w');
    $result = pg_query($dbconn, $sql);
    while ($row = pg_fetch_assoc($result)){
        fputcsv($f, $row);
    }
    fclose($f);
    pg_close($dbconn);
    http_response_code(200);
?>