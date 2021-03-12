<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Models\User;
use Exception;
use Intervention\Image\Facades\Image;

class StorePhotoJob extends PhotoJob
{
    // Don't use SerializeModels, if tries to get a newRecord from db...

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Photo
     */
    protected $photo;

    /**
     * Create a new job instance.
     * @param User $user
     * @param Photo $photo
     */
    public function __construct(User $user, Photo $photo)
    {
        parent::__construct($user, $photo);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $userPhoto = $this
            ->user
            ->photos()
            ->where('id', $this->photo->id)
            ->first();

        if (!empty($userPhoto)) {
            // Photo was saved on an earlier job
            return;
        }

        $photo = Photo::query()
            ->where('id', $this->photo->id)
            ->first();

        if (!empty($photo)) {
            // no need to generate another thumbnail, just update the reference
            $this->user->photos()->save($photo);
            return;
        }

        $ext       = pathinfo($this->photo->path, PATHINFO_EXTENSION);
        $photoName = "photo_{$this->photo->id}.{$ext}";
        $tempPhoto = file_get_contents($this->photo->path);

        if ($tempPhoto === false) {
            throw new Exception("Failed to get pixbay photo: " . $this->photo->path);
        }

        $photo = Image::make($tempPhoto);
        $photo
            ->resize($photo->width() / 2, $photo->height() / 2)
            ->save(storage_path('app/public/') . $photoName);

        $this->user->photos()->create([
            'id'   => $this->photo->id,
            'path' => 'http://localhost:8000/storage/' . $photoName
        ]);

    }
}
