<?php
    //inicio curl y parametro linea de comandos
    //$che objeto curl
    $ch = curl_init($argv[1]);
    curl_setopt(
        $ch,
        CURLOPT_RETURNTRANSFER,
        true
    );

$response = curl_exec($ch);
//CURLINFO_HTTP_CODE CODIGO RECIBIDO
$httpCode=curl_getinfo($ch, CURLINFO_HTTP_CODE);
//echo $httpCode;
switch ($httpCode) {
    case 200:
       echo "todo ok";
        break;
    case 400:
        echo "Pedido incorrecto";
        break;
    case 404:
        echo "Recurso no encontrado";
        break;    
    case 500:
        echo "Serv. Fallo";
            break;    
    default:
        echo "No hay codigo";
        break;
}
