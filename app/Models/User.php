<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $token
 * @property string $created_at
 */
class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'token'];
}
