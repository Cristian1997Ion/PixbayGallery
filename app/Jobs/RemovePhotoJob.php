<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class RemovePhotoJob extends PhotoJob
{
    use SerializesModels;

    /**
     * Create a new job instance.
     *
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
     * @throws \Exception
     */
    public function handle()
    {
        $hasOtherUsers = false;
        foreach ($this->photo->users as $user) {
            if ($user->id !== $this->user->id) {
                $hasOtherUsers = true;
            }
        }

        $this->user->photos()->detach($this->photo->id);

        if ($hasOtherUsers) {
            return;
        }

        // no one is using this image
        unlink($this->photo->getStoragePath('hq'));
        unlink($this->photo->getStoragePath('thumbnail'));
        $this->photo->delete();
    }
}
