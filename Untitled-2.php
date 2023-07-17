<?php
    $allwedResourceType =[
        'books',
        'authors',
        'genres'
    ];       

    $resourceType = $_GET['resource_type'];
    if(!in_array($resourceType,$allwedResourceType)){
        die;
    }
    switch (strtoupper($_SERVER['REQUEST_METHOD'])){
        case 'POST':
        break;
        case 'GET':
        break;
        case 'PUT':
        break;
        case 'DELETE':
        break;
       
            

    };
?>    