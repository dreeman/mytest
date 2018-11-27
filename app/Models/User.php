<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $fillable = ['login', 'password'];

    public static function getId() {
        return (isset($_SESSION['tasks_user_id'])) ? $_SESSION['tasks_user_id'] : null;
    }
}
