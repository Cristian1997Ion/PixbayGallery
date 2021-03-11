<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Photo
 * @package App\Models
 * @property int $id same as Pixbay ids
 * @property string $path
 * @property string $created_at
 */
class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'path'];

    public function users(): MorphToMany
    {
        // why polymorphic relation? in case we will have another entity,
        // let's say Post, that will also have multiple photos
        return $this->morphedByMany(User::class, 'photoable');
    }
}
