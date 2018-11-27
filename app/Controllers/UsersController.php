<?php

namespace App\Controllers;

use App\Models\User;
use Base\Request;
use Base\BaseController;

class UsersController extends BaseController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function loginForm() {
        $this->view('loginForm');
    }

    public function login()
    {
        $fields = [
            'login' => $this->request->get('login'),
            'password' => $this->request->get('password'),
        ];

        if (!$fields['login'] || !$fields['password']) {
            $errors = 'Required fields: Login, Password.';
            $this->view('loginForm', [
                'fields' => $fields,
                'errors' => $errors,
            ]);
        } else {
            $user = User::where('login', $fields['login'])->where('password', crypt($fields['password'], 'milk'))->first();
            if($user) {
                $_SESSION['tasks_user_id'] = $user->id;
                return header('Location: /');
            } else {
                $errors = 'Wrong login/password';
                $this->view('loginForm', [
                    'fields' => $fields,
                    'errors' => $errors,
                ]);
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['tasks_user_id']);
        return header('Location: /');
    }
}
