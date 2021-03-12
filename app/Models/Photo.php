<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Intervention\Image\Facades\Image;

/**
 * Class Photo
 * @package App\Models
 * @property int $id same as Pixbay ids
 * @property string $path
 * @property string $created_at
 * @property string $hq_path
 * @property User[] $users
 */
class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'path', 'hq_path'];

    public function users(): MorphToMany
    {
        // why polymorphic relation? in case we will have another entity,
        // let's say Post, that will also have multiple photos
        return $this->morphedByMany(User::class, 'photoable');
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    /**
     * @param string $type
     * @return string
     */
    public function getName($type = 'hq'): string
    {
        switch ($type) {
            case 'thumbnail':
                $photoName = "thumb_photo_{$this->id}.{$this->getExtension()}";
                break;

            case 'hq':
            default:
            $photoName = "photo_{$this->id}.{$this->getExtension()}";
        }

        return $photoName;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getStoragePath($type = 'hq'): string
    {
        return storage_path('app/public/') . $this->getName($type);
    }

    /**
     * @param string $path
     * @return mixed
     * @throws Exception
     */
    public static function downloadPhoto(string $path): \Intervention\Image\Image
    {
        if (!$tempPhoto = file_get_contents($path)) {
            throw new Exception("Failed to get pixbay photo: " . $path);
        }

        return Image::make($tempPhoto);
    }
}
