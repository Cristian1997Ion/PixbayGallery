<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function photos(): MorphToMany
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }
}
