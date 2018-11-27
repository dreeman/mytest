<?php

namespace Base;

use App\Models\User;

class BaseController
{
    public function view($view, $data = null)
    {
        $data['userId'] = User::getId();
        extract($data);
        require __DIR__ . "/../app/views/layouts/header.php";
        require __DIR__ . "/../app/views/{$view}.php";
        require __DIR__ . "/../app/views/layouts/footer.php";
    }
}