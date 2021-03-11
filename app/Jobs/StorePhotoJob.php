<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class StorePhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $photoUrl;

    /**
     * @var int
     */
    protected $photoId;

    /**
     * Create a new job instance.
     * @param User $user
     * @param int $photoId
     * @param string $photoUrl
     */
    public function __construct(User $user, int $photoId, string $photoUrl)
    {
        $this->user     = $user;
        $this->photoId  = $photoId;
        $this->photoUrl = $photoUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(5);
        $photo = $this
            ->user
            ->photos()
            ->where('id', $this->photoId)
            ->first();

        if (!empty($photo)) {
            // Photo was saved on an earlier job
            return;
        }

        $photo = Photo::query()
            ->where('id', $this->photoId)
            ->first();
        if (!empty($photo)) {
            // no need to generate another thumbnail, just update the reference
            $this->user->photos()->save($photo);
            return;
        }

        $ext       = pathinfo($this->photoUrl, PATHINFO_EXTENSION);
        $photoName = "photo_{$this->photoId}.{$ext}";
        $tempPhoto = file_get_contents($this->photoUrl);
        $photo     = Image::make($tempPhoto);

        $photo
            ->resize($photo->width() / 2, $photo->height() / 2)
            ->save(storage_path('app/public/') . $photoName);

        $this->user->photos()->create([
            'id'   => $this->photoId,
            'path' => asset('/storage/' . $photoName)
        ]);

    }
}
