<?php


namespace App\Services\PixbayService;

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
        $this->guzzle = new \GuzzleHttp\Client(['base_uri' => $config->getDomain()]);
    }

    public function getPhotos($searchTerm = ''): string
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

        return $response->getBody()->getContents();
    }
}
