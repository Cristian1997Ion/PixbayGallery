<?php


namespace App\Services\PixbayService\Response;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class GenericPhotosResponse implements Responsable
{

    /**
     * @var int
     */
    protected $photoCount;

    /**
     * @var array
     */
    protected $photos;

    /**
     * @var string
     */
    protected $remainingCacheTime;

    /**
     * @var string
     */
    protected $cacheKey;

    public function __construct(array $response)
    {
        $now                      = Carbon::now('3');
        $cachedAt                 = Carbon::create($response['cached_at']);
        $cacheExpire              = $cachedAt->addSeconds($response['cached_time']);
        $this->remainingCacheTime = $cacheExpire->diff($now);
        $this->remainingCacheTime = "{$this->remainingCacheTime->h}h {$this->remainingCacheTime->i}m {$this->remainingCacheTime->s}s";
        $this->cacheKey           = $response['cache_key'];

        $response = json_decode($response['contents']);
        foreach ($response->hits as $photo) {
            $this->photoCount++;
            $this->photos[] = [
                'id'   => $photo->id,
                'url'  => $photo->webformatURL,
                'user' => $photo->user
            ];
        }
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function asArray(): array
    {
        return [
            'photoCount'         => $this->photoCount,
            'photos'             => $this->photos,
            'remainingCacheTime' => $this->remainingCacheTime,
            'cacheKey'           => $this->cacheKey
        ];
    }

    public function toResponse($request): Response
    {
        return \response()->json($this->asArray());
    }
}
