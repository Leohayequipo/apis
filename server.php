<?php
  header('Content-Type: application/json');

  /*>curl http://localhost:8000/books -H "X-Token:0a4f8b93faad504007df78c9acb6f93ea6cc8c53"*/ 
  //echo "hola";
  /*
 if(!array_key_exists('HTTP_X_TOKEN', $_SERVER)  ){
        die;
 };
    $url = 'http://localhost:8001';
    //inicializar la llamada
   $ch = curl_init( $url );
  
    curl_setopt($ch, CURLOPT_HTTPHEADER,[
            "X-Token:{$_SERVER['HTTP_X_TOKEN']}"
        ]
    );

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true );
    
    $ret = curl_exec( $ch );
    if ( curl_errno($ch) != 0 ) {
        http_response_code( 403 );

        die; 
    }

    if($ret !== 'true'){
        http_response_code( 403 );
        die;

    };
    */

    $allwedResourceType =[
        'books',
        'authors',
        'genres'
    ];       

    $resourceType = $_GET['resource_type'];

    if(!in_array($resourceType,$allwedResourceType)){
        http_response_code( 400 );
        die; 
    }
    $books= [
        1=>[
            'titulo'=>"11111111",
            'id_autor'=>"2",
            'id_genero'=>"2",
        ],
        2=>[
            'titulo'=>"222222",
            'id_autor'=>"1",
            'id_genero'=>"1",
        ],
        3=>[
            'titulo'=>"333333333",
            'id_autor'=>"2",
            'id_genero'=>"2",
        ],
    
    ];
  

    $resourceId =array_key_exists('resource_id',$_GET) ? $_GET['resource_id'] : '';
    switch (strtoupper($_SERVER['REQUEST_METHOD'])){
        case 'GET':
            if(empty($resourceId)){
                echo json_encode($books);
            }else{
                if(array_key_exists($resourceId, $books)){
                    echo json_encode($books[$resourceId]);
                }else{
                    http_response_code(404);
                }
            }
              /*
                esto ejecuto en cmd
                curl -X "GET" http://localhost:8000/books/1 -d "{\"titulo\":\"nuevotitulo\",\"id_autor\":11,\"id_genero\":6}"
                */


        

        break;
        case 'POST':
            $json = file_get_contents('php://input');
            $books[] = json_decode($json,true);
            //devolver id
            //echo array_keys($books)[count($books)-1];
            echo json_encode($books);
        break;
      
        case 'PUT':
            //validar si existe
            if(!empty($resourceId) && array_key_exists($resourceId,$books)){
                //entrada cruda
                $json =file_get_contents("php://input");
                //de json a elemento
                $books[$resourceId]= json_decode($json, true);
                //mostramos la nueva coleccion
                echo json_encode($books);
                /*
                esto ejecuto en cmd
                curl -X "PUT" http://localhost:8000/books/1 -d "{\"titulo\":\"nuevotitulo\",\"id_autor\":11,\"id_genero\":6}"
                */

            }
        break;
        case 'DELETE':
            //existe el recurso
            if(!empty($resourceId) && array_key_exists($resourceId,$books)){
                unset($books[$resourceId]);
            };
            echo json_encode($books);
                /*
                esto ejecuto en cmd
                curl -X "DELETE" http://localhost:8000/books/1 
                */

        break;
       
            

    };
?>    