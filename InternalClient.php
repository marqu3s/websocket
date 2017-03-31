<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 30/03/17
 * Time: 21:45
 */
require __DIR__ . '/vendor/autoload.php';

class InternalClient extends Thruway\Peer\Client
{
    function __construct()
    {
        parent::__construct("realm1");

    }

    public function onSessionStart($session, $transport)
    {
        // TODO: now that the session has started, setup the stuff
        echo "--------------- Hello from InternalClient ------------";

        $this->getCallee()->register($this->session, 'com.example.getphpversion', [$this, 'getPhpVersion']);
    }

    function getPhpVersion()
    {
        return [phpversion()];
    }
}

