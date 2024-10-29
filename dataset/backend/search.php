<?php 
    require_once 'dbconnection.php';
    require_once '../login/jwt.php';
    require_once '../login/authorization.php';

    $industry_search = explode(",", $_POST['industry_search']);
    $industry_negation_search = explode(",", $_POST['industry_negation_search']);
    $cname_search = explode(",", $_POST['cname_search']);
    $cname_negation_search = explode(",", $_POST['cname_negation_search']);
    $city_search = explode(",", $_POST['city_search']);
    $city_negation_search = explode(",", $_POST['city_negation_search']);

    $state = explode(",", $_POST['state']);
    $phonetype = explode(",", $_POST['phonetype']);
    $category = explode(",", $_POST['category']);

    search(
        $dbconn,
        array($industry_search, $industry_negation_search),
        array($cname_search, $cname_negation_search),
        array($city_search, $city_negation_search),
        $state,
        $phonetype,
        $category,
    );
?>