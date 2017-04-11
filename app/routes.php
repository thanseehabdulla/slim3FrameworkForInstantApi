<?php

use App\Controllers\_ApiController;

use App\Controllers\_Controller;
use App\Controllers\_Controller_oAuth2;

//additionally added
use App\Controllers\_UserController_oAuth2;


use App\Controllers\_oAuth2TokenController;

//additionally added
use App\Controllers\UserController;


// Routes

$app->get('/', _ApiController::class.':showHello')
    ->setName('hellopage');


$app->post('/login', UserController::class.':login')
->setName('hellopage');

$app->post('/getdataByAgentDealerID', _Controller_oAuth2::class.':getdataByAgentDealerID')
->setName('hellopage');

$app->post('/getPaymentByUserID', _Controller_oAuth2::class.':getPaymentByUserID')
->setName('hellopage');

$app->post('/getSpinnerItem', _Controller_oAuth2::class.':getSpinnerItem')
->setName('hellopage');

$app->post('/insertPayment', _Controller_oAuth2::class.':insertPayment')
->setName('hellopage');



// oAuth2
$app->group('/oauth', function () {
    $this->post('/token', _oAuth2TokenController::class.':token');
});

// Product controller
$app->group('/product', function () {
    $this->get   ('',             _Controller_oAuth2::class.':getAll');
    $this->get   ('/{id:[0-9]+}', _Controller_oAuth2::class.':get');
    $this->post  ('',             _Controller_oAuth2::class.':add');
    $this->put   ('/{id:[0-9]+}', _Controller_oAuth2::class.':update');
    $this->delete('/{id:[0-9]+}', _Controller_oAuth2::class.':delete');
//})->add(function ($request, $response, $next) {
//	$this->settings['localtable'] = "categories";
//    $response = $next($request, $response);
//    return $response;
});






// Paymenttype controller
$app->group('/paymenttype', function () {
    $this->get   ('',             _Controller_oAuth2::class.':getAll');
    $this->get   ('/{id:[0-9]+}', _Controller_oAuth2::class.':get');
    $this->post  ('',             _Controller_oAuth2::class.':add');
    $this->put   ('/{id:[0-9]+}', _Controller_oAuth2::class.':update');
    $this->delete('/{id:[0-9]+}', _Controller_oAuth2::class.':delete');
//})->add(function ($request, $response, $next) {
//	$this->settings['localtable'] = "categories";
//    $response = $next($request, $response);
//    return $response;
});




// Paymenttranscation controller
$app->group('/paymenttransaction', function () {
    $this->get   ('',             _Controller_oAuth2::class.':getAll');
    $this->get   ('/{id:[0-9]+}', _Controller_oAuth2::class.':get');
    $this->post  ('',             _Controller_oAuth2::class.':add');
    $this->put   ('/{id:[0-9]+}', _Controller_oAuth2::class.':update');
    $this->delete('/{id:[0-9]+}', _Controller_oAuth2::class.':delete');
//})->add(function ($request, $response, $next) {
//	$this->settings['localtable'] = "categories";
//    $response = $next($request, $response);
//    return $response;
});








// Books controller
$app->group('/bookdata', function () {
    $this->get   ('',             _Controller::class.':getAll');
    $this->get   ('/{id:[0-9]+}', _Controller::class.':get');
    $this->post  ('',             _Controller::class.':add');
    $this->put   ('/{id:[0-9]+}', _Controller::class.':update');
    $this->delete('/{id:[0-9]+}', _Controller::class.':delete');
})->add(function ($request, $response, $next) {
    $this->settings['localtable'] = "books";
    $response = $next($request, $response);
    return $response;
});

// Custom Controllers
//$app->group('/mycustom', function () {
//    $this->get   ('',             MyCustomController::class.':getAll');
//    $this->post
//    ...
//});









