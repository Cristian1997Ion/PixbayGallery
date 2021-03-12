<?php


namespace App\Services\PixbayService;

use App\Services\PixbayService\Response\GenericPhotosResponse;
use Exception;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;


class Client
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Client constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->guzzle = new \GuzzleHttp\Client(['base_uri' => $config->getDomain() . '.kikiki']);
    }

    /**
     * @param $page
     * @param string $searchTerm
     * @return GenericPhotosResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function getPhotos($page, $searchTerm = ''): GenericPhotosResponse
    {
        $cacheKey  = "pixbay_photos_{$searchTerm}_{$page}";
        $cacheTime = 3600 * 24;

        if (!$response = Cache::get($cacheKey)) {
            $response = $this->guzzle->get(
                $this->config->getEndpoint('photos'),
                [
                    RequestOptions::QUERY => [
                        'key'      => $this->config->getApiKey(),
                        'q'        => $searchTerm,
                        'page'     => $page,
                        'per_page' => 21
                    ]
                ]
            );

            $response = self::handleResponse($response, $cacheKey, $cacheTime);
            Cache::put($cacheKey, $response, $cacheTime);
        }

        return new GenericPhotosResponse($response);
    }

    /**
     * @param $id
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function getPhoto($id): Photo
    {
        $cacheKey  = "photo_{$id}";
        $cacheTime = 24 * 3600;
        if (!$response = Cache::get($cacheKey)) {
            $response = $this->guzzle->get(
                $this->config->getEndpoint('photos'),
                [
                    RequestOptions::QUERY => [
                        'key' => $this->config->getApiKey(),
                        'id'  => $id
                    ]
                ]
            );

            $response = self::handleResponse($response, $cacheKey, $cacheTime);
            Cache::put($cacheKey, $response, $cacheTime);
        }

        $photos = App::make(GenericPhotosResponse::class, ['response' => $response])->getPhotos();
        if (empty($photos)) {
            throw new Exception("Photo not found");
        }

        return new Photo($photos[0]['id'], $photos[0]['user'], $photos[0]['url'], $photos[0]['hqUrl']);
    }

    /**
     * @param $response
     * @param $cacheKey
     * @param $cacheTime
     * @throws Exception
     */
    protected static function handleResponse($response, $cacheKey, $cacheTime): array
    {
        if ($response->getStatusCode() !== 200) {
            throw new Exception("Something went wrong while downloading the photos...");
        }

        $response = [
            'contents'    => $response->getBody()->getContents(),
            'cached_at'   => Carbon::now('3')->toString(),
            'cached_time' => $cacheTime,
            'cache_key'   => $cacheKey
        ];

        return $response;
    }
}
