<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 30/03/17
 * Time: 22:08
 */

require __DIR__ . '/vendor/autoload.php';

$authid = "joao";
$key = "myKeyIs@wesome"; // CHANGE THIS

$token = [
    "authid" => $authid,
    "authroles" => ["user", "dir"]
];

$jwt = \Firebase\JWT\JWT::encode($token, $key);

echo $jwt;
