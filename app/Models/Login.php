<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User
 *
 * This model handles Login operations for the registered users.
 *
 * @category   Login Management
 * @package    App\Models\Login
 * @author     Muthu velan
 * @created    02-03-2025
 * @updated    02-03-2025
 */

class Login extends Authenticatable implements JWTSubject
{
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
