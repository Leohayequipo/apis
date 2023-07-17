<?php

$matches=[];
echo "probando";

echo $_SERVER["REQUEST_URI"];
  // Excepcion para las  url principal sea index.html
  if (in_array( $_SERVER["REQUEST_URI"], [ '/index.html', '/', '' ] )) {
    echo file_get_contents( 'index.html' );
    die;
}
//if(preg_match('/\/([^\/]+)\/([^\/]+)/',$_SERVER["REQUEST_URI"],$matches))
  if(preg_match('/\/([^\/]+)\/([^\/]+)/',$_SERVER["REQUEST_URI"],$matches))

{
    /*var_dump ($matches);
    echo $_SERVER["REQUEST_URI"];*/

    $_GET['resource_type']=$matches[1];    
    $_GET['resource_id']=$matches[2];
   
    error_log(print_r($matches,1));
    require 'server.php';
}else if(preg_match('/\/([^\/]+)\/?/',$_SERVER["REQUEST_URI"],$matches))
{   
    $_GET['resource_type']=$matches[1];        
    error_log(print_r($matches,1));
    require 'server.php';
}else
{
    error_log('No matches. Entro por else en router');
    http_response_code(404);
}

?>