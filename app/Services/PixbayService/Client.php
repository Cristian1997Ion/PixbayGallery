<?php


namespace App\Services\PixbayService;

use App\Services\PixbayService\Response\GenericPhotosResponse;
use GuzzleHttp\RequestOptions;

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

    public function getPhotos($searchTerm = ''): array
    {
        $response = $this->guzzle->get(
            $this->config->getEndpoint('photos'),
            [
                RequestOptions::QUERY => [
                    'key' => $this->config->getApiKey(),
                    'q' => $searchTerm
                ]
            ]
        );

        $genericResponse = new GenericPhotosResponse($response->getBody()->getContents());

        return $genericResponse->asArray();
    }
}
