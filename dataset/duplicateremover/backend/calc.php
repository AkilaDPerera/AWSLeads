<?php
    require '../../backend/dbconnection.php';

    $f=fopen('../result/result.csv','w');
    
    $uniquesetsql = 'SELECT columnA, columnB FROM datasetA A LEFT JOIN datasetB B ON A.columnA = B.columnC WHERE B.columnC IS NULL;';
    $result = pg_query($dbconn, $uniquesetsql);
    while ($row = pg_fetch_assoc($result)){
        $row[] = "Unique";
        fputcsv($f, $row);
    }

    $dupsetsql = 'SELECT columnA, columnB FROM datasetA A LEFT JOIN datasetB B ON A.columnA = B.columnC WHERE B.columnC IS NOT NULL;';
    $result2 = pg_query($dbconn, $dupsetsql);
    while ($row = pg_fetch_assoc($result2)){
        $row[] = "Duplicate";
        fputcsv($f, $row);
    }

    fclose($f);
    pg_close($dbconn);
    http_response_code(200);
?>