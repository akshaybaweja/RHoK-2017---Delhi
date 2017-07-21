<?php

$request = new HttpRequest();
$request->setUrl('https://api.uber.com/v1.2/history');
$request->setMethod(HTTP_METH_GET);

$request->setHeaders(array(
  'cache-control' => 'no-cache',
  'content-type' => 'application/json',
  'accept-language' => 'en_US',
  'authorization' => 'authorization-token-here'
));

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}

?>
