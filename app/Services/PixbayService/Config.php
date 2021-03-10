<?php


namespace App\Services\PixbayService;


class Config
{
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $domain;

    /**
     * @var array
     */
    protected $endpoints;

    /**
     * Config constructor.
     * @param string|null $apiKey
     * @param string|null $domain
     * @param array|null $endpoints
     */
    public function __construct(string $apiKey = null, string $domain = null, array $endpoints = null)
    {
        $this->apiKey    = $apiKey ?? config('services.pixbay.key');
        $this->domain    = $domain ?? config('services.pixbay.domain');
        $this->endpoints = $endpoints ?? config('services.pixbay.endpoints');
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return array
     */
    public function getEndpoints(): array
    {
        return $this->endpoints;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getEndpoint(string $name)
    {
        return $this->endpoints[$name];
    }

    public function getEndpointUrl(string $name)
    {
        return $this->endpoints[$name]['url'];
    }
}
