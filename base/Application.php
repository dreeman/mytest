<?php

namespace Base;

use Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    protected $router;

    public function __construct()
    {
        $dbConfig = require_once __DIR__ . '/../config/dbconfig.php';
        $capsule = new Capsule;
        $capsule->addConnection($dbConfig);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->router = new Router(new Request());
        require_once __DIR__ . '/../app/routes.php';
        $this->router->run();
    }
}
