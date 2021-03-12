<?php


namespace App\Services\PixbayService;


final class Photo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $hqUrl;

    /**
     * @param int $id
     * @param string $author
     * @param string $url
     * @param string $hqUrl
     * @return Photo
     */
    public static function make(int $id, string $author, string $url, string $hqUrl): Photo
    {
        return new self($id, $author, $url, $hqUrl);
    }

    /**
     * Photo constructor.
     * @param int $id
     * @param string $author
     * @param string $url
     * @param string $hqUrl
     */
    public function __construct(int $id, string $author, string $url, string $hqUrl)
    {
        $this->id     = $id;
        $this->author = $author;
        $this->url    = $url;
        $this->hqUrl  = $hqUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getHQUrl(): string
    {
        return $this->getUrl();
    }


}
