<?php

use App\Controllers\_ApiController;

// Generic Controllers / DataAccess
use App\Controllers\_Controller;
use App\Controllers\_Controller_oAuth2;






use App\DataAccess\_DataAccess;

use App\DataAccess\_oAuth2_CustomStorage;
use App\Controllers\_oAuth2TokenController;


// User data operations
use App\Controllers\UserController;
use App\DataAccess\UserDataAccess;

//additionally added
use App\Controllers\_UserController_oAuth2;


// Custom Controllers / DataAccess
//use App\Controllers\MyCustomController;
//use App\DataAccess\MyCustomDataAccess;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));

    return $logger;
};

// Database
$container['pdo'] = function ($c) {
    $settings = $c->get('settings')['pdo'];

    return new PDO($settings['dsn'], $settings['username'], $settings['password']);
};

// oAuth
$container['oAuth'] = function ($c) {
	
    $storage = new App\DataAccess\_oAuth2_CustomStorage($c->get('pdo'));

    // Pass a storage object or array of storage objects to the OAuth2 server class
    $server = new OAuth2\Server($storage);
    
    // add grant types
	$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
    $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

    return $server;
};



// APIController
$container['App\Controllers\_ApiController'] = function ($c) {
    return new _ApiController($c->get('logger'),$c->get('settings')['PoweredBy']);
};

// Generic Controller
$container['App\Controllers\_Controller'] = function ($c) {
    return new _Controller($c->get('logger'), $c->get('App\DataAccess\_DataAccess'));
};


// generic dataaccess
// $container['App\DataAccess\UserDataAccess'] = function ($c) {
//    return new UserDataAccess($c->get('logger'), $c->get('pdo'), '');
// };



//generic dataaccess
$container['App\DataAccess\UserDataAccess'] = function ($c) {
   $localtable = $c->get('settings')['localtable']!='' ? $c->get('settings')['localtable'] : '';
    return new UserDataAccess($c->get('logger'), $c->get('pdo'), $localtable);;
};

// Generic DataAccess
$container['App\DataAccess\_DataAccess'] = function ($c) {
	$localtable = $c->get('settings')['localtable']!='' ? $c->get('settings')['localtable'] : '';
    return new _DataAccess($c->get('logger'), $c->get('pdo'), $localtable);
};

// oAuth Controller for retrieving tokens
$container['App\Controllers\_oAuth2TokenController'] = function ($c) {
    return new _oAuth2TokenController($c->get('logger'), $c->get('oAuth'));
};

// Generic Controller oAuth2
$container['App\Controllers\_Controller_oAuth2'] = function ($c) {
    return new _Controller_oAuth2($c->get('logger'), $c->get('App\DataAccess\_DataAccess'), $c->get('oAuth'));
};

// Generic Controller oAuth2
$container['App\Controllers\_UserController_oAuth2'] = function ($c) {
    return new _UserController_oAuth2($c->get('logger'), $c->get('App\DataAccess\UserDataAccess'), $c->get('oAuth'));
};

// User data operations
$container['App\Controllers\UserController'] = function ($c) {
   return new UserController($c->get('logger'), $c->get('App\DataAccess\UserDataAccess'));
};





// Custom Controllers / DataAccess
// ...
//$container['App\Controllers\MyCustomController'] = function ($c) {
//    return new MyCustomController($c->get('logger'), $c->get('App\DataAccess\MyCustomDataAccess'));
//};

//$container['App\DataAccess\MyCustomDataAccess'] = function ($c) {
//    return new MyCustomDataAccess($c->get('logger'), $c->get('pdo'), '');
//};

?>