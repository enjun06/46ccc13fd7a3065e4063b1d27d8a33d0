<?php

use App\Router;

$router = new Router();

$router->add('GET', '/api/mail', 'EmailController@listEmails');
$router->add('GET', '/api/mail/{id}', 'EmailController@showEmail');
$router->add('POST', '/api/mail', 'EmailController@createEmail');
$router->add('DELETE', '/api/mail/{id}', 'EmailController@deleteEmail');
$router->add('GET', '/api', 'EmailController@healthCheck');

return $router;
