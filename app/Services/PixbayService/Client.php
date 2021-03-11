<?php


namespace App\Services\PixbayService;

use App\Services\PixbayService\Response\GenericPhotosResponse;
use Exception;
use GuzzleHttp\RequestOptions;
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

    public function getPhotos($searchTerm = ''): GenericPhotosResponse
    {
        $cacheKey = "photos_{$searchTerm}";
        if (!$response = Cache::get($cacheKey)) {
            $response = $this->guzzle->get(
                $this->config->getEndpoint('photos'),
                [
                    RequestOptions::QUERY => [
                        'key' => $this->config->getApiKey(),
                        'q' => $searchTerm
                    ]
                ]
            );

            if ($response->getStatusCode() !== 200) {
                throw new Exception("Something went wrong while downloading the photos");
            }

            $response = $response->getBody()->getContents();
            Cache::put($cacheKey, $response, 24 * 3600);
        }


        return new GenericPhotosResponse($response);
    }
}
