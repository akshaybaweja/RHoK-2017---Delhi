<?php

$request = new HttpRequest();
$request->setUrl('https://api.uber.com/v1.2/history');
$request->setMethod(HTTP_METH_GET);

$request->setHeaders(array(
  'postman-token' => 'c4331781-dcf5-b62b-07aa-51965e74295a',
  'cache-control' => 'no-cache',
  'content-type' => 'application/json',
  'accept-language' => 'en_US',
  'authorization' => 'Bearer KA.eyJ2ZXJzaW9uIjoyLCJpZCI6IjY1cHo5SmlwU2cySW5VbHJ4VHlaMEE9PSIsImV4cGlyZXNfYXQiOjE1MDI3NTczMzEsInBpcGVsaW5lX2tleV9pZCI6Ik1RPT0iLCJwaXBlbGluZV9pZCI6MX0.wyLL88vRwlheswmllMOyPIB7EbqgWIFl4UD7nkpIqTM'
));

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}

?>