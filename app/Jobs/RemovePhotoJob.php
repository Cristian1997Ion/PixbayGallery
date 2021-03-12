<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RemovePhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $photoId;

    /**
     * @var Photo
     */
    protected $photo;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Photo $photo
     */
    public function __construct(User $user, Photo $photo)
    {
        $this->user  = $user;
        $this->photo = $photo;
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
        Storage::delete("/photo_{$this->photo->id}.jpg");
        $this->photo->delete();
    }
}
