<?php


namespace App\Services\PixbayService;



use Exception;

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
     * @throws Exception
     */
    public function getEndpoint(string $name)
    {
        if (empty($this->endpoints[$name])) {
            throw new Exception("Couldn't find '{$name}' endpoint!");
        }

        return $this->endpoints[$name];
    }

}
