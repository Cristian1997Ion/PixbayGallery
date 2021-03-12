<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Models\User;
use Exception;

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

        $thumb   = Photo::downloadPhoto($this->photo->path);
        $hqPhoto = Photo::downloadPhoto($this->photo->hq_path);

        $thumb
            ->resize($thumb->width() / 2, $thumb->height() / 2)
            ->save($this->photo->getStoragePath('thumbnail'));

        $hqPhoto
            ->save($this->photo->getStoragePath('hq'));

        $this->user->photos()->create([
            'id'   => $this->photo->id,
            'path' => '/storage/' . $this->photo->getName('thumbnail'),
            'hq_path' => '/storage/' . $this->photo->getName('hq'),
        ]);

    }
}
