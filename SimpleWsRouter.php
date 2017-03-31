<?php

require __DIR__ . '/vendor/autoload.php';
require 'InternalClient.php';
require 'JwtAuthenticationProvider.php';

use Thruway\Peer\Router;
use Thruway\Transport\RatchetTransportProvider;
use Thruway\Authentication\AuthenticationManager;
use Thruway\Authentication\AuthorizationManager;

$transportProvider = new RatchetTransportProvider("127.0.0.1", 9090);

$authorizationManager = new AuthorizationManager('realm1');
// don't allow anything by default
$authorizationManager->flushAuthorizationRules(false);
// allow sessions in the "dir" role to subscribe to sales.numbers
$salesRule = new stdClass();
$salesRule->role   = "dir";
$salesRule->action = "subscribe";
$salesRule->uri    = "sales.numbers";
$salesRule->allow  = true;
$authorizationManager->addAuthorizationRule([$salesRule]);

// allow sessions in the  "user" role to publish to sales.numbers
$bookkeepingRule = new stdClass();
$bookkeepingRule->role   = "sales";
$bookkeepingRule->action = "publish";
$bookkeepingRule->uri    = "sales.numbers";
$bookkeepingRule->allow  = true;
$authorizationManager->addAuthorizationRule([$bookkeepingRule]);

$router = new Router();
$router->registerModule(new AuthenticationManager());
$router->addInternalClient(new JwtAuthenticationProvider(['realm1'], 'myKeyIs@wesome')); // CHANGE YOUR KEY
$router->registerModule($authorizationManager);
$router->registerModule($transportProvider);
$router->addInternalClient(new InternalClient());
$router->start();
