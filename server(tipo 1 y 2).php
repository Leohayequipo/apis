<?php
  header('Content-Type: application/json');
    /*en consola
    authentication HTTP
    $user = array_key_exists('PHP_AUTH_USER',$_SERVER) ? $_SERVER['PHP_AUTH_USER'] : "";
    $pwd = array_key_exists('PHP_AUTH_PW',$_SERVER) ? $_SERVER['PHP_AUTH_PW'] : "";
    if($user !== 'mauro' || $pwd !== '1234'){
        die;
    }
   
        curl http://mario:1234@localhost:8000/books
    */
    /*hmac modo mas seguro id + hash*/
    //encabezados especiales por eso la X
   
   
   /********************************************* */
   //tipo2
// if(!array_key_exists('HTTP_X_HASH', $_SERVER) || !array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) || !array_key_exists('HTTP_X_UID', $_SERVER) ){
//     die;
// };
// list($hash,$uid,$timestamp) =[
//     $_SERVER['HTTP_X_HASH'],
//     $_SERVER['HTTP_X_UID'],
//     $_SERVER['HTTP_X_TIMESTAMP']
// ];
// //clave secreta
// $secret = "secreto";
// //crear hash
// $newHash = sha1($uid.$timestamp.$secret);
//
// //compara hash
// if ($newHash !== $hash) {
//     die;
// }
///*
//curl http://localhost:8000/books -H 'X-HASH: 79f64087f5b57c7eb602d59ee89d6443ed51c1b8' -H 'X-UID:1' -H 'X-TIMESTAMP: 1689183810'
//*/
 /******************************************* */
  /********************************************* */
   //tipo3tokens

   if(!array_key_exists('HTTP_X_TOKEN', $_SERVER)  ){
        die;
    };
    $url = 'http://localhost:8001';
    //inicializar la llamada
    $ch = curl_init( $url );
  
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
            "X-Token:{$_SERVER['HTTP_X_TOKEN']}"
        ]
    );

    curl_setopt(
        $ch,
        CURLOPT_RETURNTRANSFER,
        true
    );

    /*
    parte del 2
    $ret = curl_exec( $ch );

    if ( curl_errno($ch) != 0 ) {
        die ( curl_error($ch) );
    }

    if($ret !== 'true'){
        http_response_code( 403 );
        die;

    };*/



        list($hash,$uid,$timestamp) =[
            $_SERVER['HTTP_X_HASH'],
            $_SERVER['HTTP_X_UID'],
            $_SERVER['HTTP_X_TIMESTAMP']
        ];
        //clave secreta
        $secret = "secreto";
        //crear hash
        $newHash = sha1($uid.$timestamp.$secret);

        //compara hash
        if ($newHash !== $hash) {
            die;
        }
    /*
    curl http://localhost:8000/books -H 'X-HASH: 79f64087f5b57c7eb602d59ee89d6443ed51c1b8' -H 'X-UID: 1' -H 'X-TIMESTAMP: 1689183810'
    */
    /******************************************* */

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
  

    $resourceId =array_key_exists('resource_id',$_GET) ? $_GET['resource_id'] : '';
    switch (strtoupper($_SERVER['REQUEST_METHOD'])){
        case 'GET':
            if(empty($resourceId)){
                echo json_encode($books);
            }else{
                if(array_key_exists($resourceId, $books)){
                    echo json_encode($books[$resourceId]);
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