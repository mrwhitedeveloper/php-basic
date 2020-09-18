<?php
function redirect($url, $statusCode = 303)
{
      if (headers_sent() === false){
          header('Location: ' . $url, true, $statusCode);
      }
   die();
}
?>
