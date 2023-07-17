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
    $books= [
        1=>[
            'titulo'=>"aaa",
            'id_autor'=>"2",
            'id_genero'=>"2",
        ],
        2=>[
            'titulo'=>"bbb",
            'id_autor'=>"1",
            'id_genero'=>"1",
        ],
        3=>[
            'titulo'=>"cc",
            'id_autor'=>"2",
            'id_genero'=>"2",
        ],
    
    ];
    header('Content-Type: application/json');

    $resourceId =array_key_exists('resource_id',$_GET) ? $_GET['resource_id'] : '';
    switch (strtoupper($_SERVER['REQUEST_METHOD'])){
        case 'POST':
        break;
        case 'GET':
            if(empty($resourceId)){
                echo json_encode($books);
            }else{
                if(array_key_exists($resourceId, $books)){
                    echo json_encode($books[$resourceId]);

                }
            }

        

        break;
        case 'PUT':
        break;
        case 'DELETE':
        break;
       
            

    };
?>    