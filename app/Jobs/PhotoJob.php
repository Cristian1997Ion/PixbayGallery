<?php


namespace App\Jobs;


use App\Models\Photo;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

abstract class PhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;


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
        $this->user  = $user;
        $this->photo = $photo;
    }
}
