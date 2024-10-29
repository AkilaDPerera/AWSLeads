<?php
    require 'constant.php';

    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $dbconn = pg_connect($conn_string);

    function removeEmptyStringFromArray($var){ return ($var!==""); }

    function getConditionString($industry, $cname, $city, $state, $phonetype, $category) {
        $sql = ""; $num_keywords = 0;

        $industryClean = array_filter($industry[0], "removeEmptyStringFromArray");
        if (count($industryClean)>0){ $sql .= "( "; }
        foreach ($industryClean as $keyword) {
            $sql .= "LOWER(Industry) LIKE '%" . pg_escape_string($keyword) . "%' OR ";
            $num_keywords += 1;
        }
        if (count($industryClean)>0){ $sql = substr($sql, 0, -4)." ) AND "; }

        $industryNClean = array_filter($industry[1], "removeEmptyStringFromArray");
        if (count($industryNClean)>0){ $sql .= "( "; }
        foreach ($industryNClean as $keyword) {
            $sql .= "LOWER(Industry) NOT LIKE '%" . pg_escape_string($keyword) . "%' AND ";
            $num_keywords += 1;
        }
        if (count($industryNClean)>0){ $sql = substr($sql, 0, -5)." ) AND "; }

        $cnameClean = array_filter($cname[0], "removeEmptyStringFromArray");
        if (count($cnameClean)>0){ $sql .= "( "; }
        foreach ($cnameClean as $keyword) {
            $sql .= "LOWER(Companyname) LIKE '%" . pg_escape_string($keyword) . "%' OR ";
            $num_keywords += 1;
        }
        if (count($cnameClean)>0){ $sql = substr($sql, 0, -4)." ) AND "; }

        $cnameNClean = array_filter($cname[1], "removeEmptyStringFromArray");
        if (count($cnameNClean)>0){ $sql .= "( "; }
        foreach ($cnameNClean as $keyword) {
            $sql .= "LOWER(Companyname) NOT LIKE '%" . pg_escape_string($keyword) . "%' AND ";
            $num_keywords += 1;
        }
        if (count($cnameNClean)>0){ $sql = substr($sql, 0, -5)." ) AND "; }

        $cityClean = array_filter($city[0], "removeEmptyStringFromArray");
        if (count($cityClean)>0){ $sql .= "( "; }
        foreach ($cityClean as $keyword) {
            $sql .= "LOWER(City) LIKE '%" . pg_escape_string($keyword) . "%' OR ";
            $num_keywords += 1;
        }
        if (count($cityClean)>0){ $sql = substr($sql, 0, -4)." ) AND "; }

        $cityNClean = array_filter($city[1], "removeEmptyStringFromArray");
        if (count($cityNClean)>0){ $sql .= "( "; }
        foreach ($cityNClean as $keyword) {
            $sql .= "LOWER(City) NOT LIKE '%" . pg_escape_string($keyword) . "%' AND ";
            $num_keywords += 1;
        }
        if (count($cityNClean)>0){ $sql = substr($sql, 0, -5)." ) AND "; }

        $stateClean = array_filter($state, "removeEmptyStringFromArray");
        if (count($stateClean)!=54){
            if (count($stateClean)>0){ $sql .= "( "; }
            foreach ($stateClean as $keyword) {
                $sql .= "State='" . pg_escape_string($keyword) . "' OR ";
                $num_keywords += 1;
            }
            if (count($stateClean)>0){ $sql = substr($sql, 0, -4)." ) AND "; }
        }

        $phonetypeClean = array_filter($phonetype, "removeEmptyStringFromArray");
        if (count($phonetypeClean)!=3){
            if (count($phonetypeClean)>0){ $sql .= "( "; }
            foreach ($phonetypeClean as $keyword) {
                $sql .= "Phonetype='" . pg_escape_string($keyword) . "' OR ";
                $num_keywords += 1;
            }
            if (count($phonetypeClean)>0){ $sql = substr($sql, 0, -4)." ) AND "; }
        }

        $categoryClean = array_filter($category, "removeEmptyStringFromArray");
        if (count($categoryClean)!=25){
            if (count($categoryClean)>0){ $sql .= "( "; }
            foreach ($categoryClean as $keyword) {
                $sql .= "Category='" . pg_escape_string($keyword) . "' OR ";
                $num_keywords += 1;
            }
            if (count($categoryClean)>0){ $sql = substr($sql, 0, -4)." ) AND "; }
        }
        if (count($categoryClean)==25){ 
            $sql .= "( ";
            $sql .= "Category!='" . "ALL" . "' OR ";
            $sql = substr($sql, 0, -4)." ) AND ";
            $num_keywords += 1; 
        }

        if (str_ends_with($sql, " AND ")){ $sql = substr($sql, 0, -5); }

        return array($sql, $num_keywords);
    }

    function search($dbconn, $industry, $cname, $city, $state, $phonetype, $category) {
        $sql = 'SELECT id, phone, phonetype, companyname, address, city, state, zip, industry, category 
        FROM phonebook A LEFT JOIN exceptiontable B ON A.phone = B.numbertoremove WHERE B.numbertoremove IS NULL AND ';
        $queryCondition = getConditionString($industry, $cname, $city, $state, $phonetype, $category);

        $sql .= $queryCondition[0];
        $num_keywords = $queryCondition[1]; 

        $files = glob('../data/*');
        foreach($files as $file){ 
            if(is_file($file)) { unlink($file); }
        }


        // $files = glob('../exception/*');
        // $exceptionlist = array();
        // foreach($files as $file){ 
        //     if (str_ends_with($file, "exceptionlist.csv")){
        //         $contents = file_get_contents($file);
        //         $exceptionlist = explode(',', $contents);
        //     }
        // }

        if ($num_keywords != 0) {
            $phones = []; $lastread = 0; $i=0; $bulksize = 500000; $completed=false;
            $fileno = 1;
            $headers = array("Id", "Phone", "Phone Type", "Company Name", "Address", "City", "State", "Zip", "Industry", "Category");

            $f=fopen('../data/last_query'.$fileno.'.csv','w'); fputcsv($f, $headers);
            $sqlloop = $sql." LIMIT ".$bulksize." OFFSET ".$lastread.";";
            
            while (!$completed){
                $result = pg_query($dbconn, $sqlloop);
                while ($row = pg_fetch_assoc($result)){
                    // if (in_array($row["phone"], $exceptionlist)){ continue; };
                    // echo print_r($row);
                    fputcsv($f, $row);
                    $lastread += 1;
                    $i += 1;
                    if($lastread<=5000){ $phones[] = $row; }
                }
                if ($i==$bulksize){
                    // Let's move to the next iteration
                    $i = 0;
                    if ($lastread%1000000 == 0){
                        $fileno += 1; 
                        fclose($f);
                        $f=fopen('../data/last_query'.$fileno.'.csv','w'); fputcsv($f, $headers);
                    }
                    $sqlloop = $sql." LIMIT ".$bulksize." OFFSET ".($lastread).";";
                } else {
                    // all read
                    $completed = true;
                }
            }
            fclose($f);
            pg_close($dbconn);

            echo json_encode(array(
                "data"=> array_slice($phones, 0, 5000), 
                "count"=> $lastread,
                "query"=> $sql
            ));
        } else {
            echo json_encode(array(
                "data"=>array(),
                "count"=>0,
                "query"=> $sql
            ));
        }
    }

    function getcount($dbconn, $industry, $cname, $city, $state, $phonetype, $category) {
        $sql = 'SELECT * FROM phonebook WHERE ';
        $queryCondition = getConditionString($industry, $cname, $city, $state, $phonetype, $category);

        $sql .= $queryCondition[0]." LIMIT 5000;";
        $num_keywords = $queryCondition[1]; 

        $phones = [];
        if ($num_keywords != 0) {
            $result = pg_query($dbconn, $sql);
            while ($row = pg_fetch_assoc($result)) {
                $phones[] = $row;
            }
            pg_close($dbconn);
            
            echo json_encode(array(
                "data"=> $phones, 
                "count"=> count($phones),
                "query"=> $sql
            ));
        } else {
            echo json_encode(array(
                "data"=>$phones,
                "count"=>0,
                "query"=> $sql
            ));
        }
    }

?>
