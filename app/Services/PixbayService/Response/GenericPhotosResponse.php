<?php


namespace App\Services\PixbayService\Response;


class GenericPhotosResponse
{

    /**
     * @var int
     */
    protected $photoCount;

    /**
     * @var array
     */
    protected $photos;

    public function __construct(string $response)
    {
        $response = json_decode($response);
        foreach ($response->hits as $photo) {
            $this->photoCount++;
            $this->photos[] = [
                'id'   => $photo->id,
                'url'  => $photo->webformatURL,
                'user' => $photo->user
            ];
        }
    }

    public function asArray(): array
    {
        return [
            'photoCount' => $this->photoCount,
            'photos'     => $this->photos,
        ];
    }
}
