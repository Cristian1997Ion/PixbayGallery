<?php


namespace App\Services\PixbayService;


final class Photo
{
    private $id;
    private $author;
    private $url;

    public static function make($id, $author, $url): Photo
    {
        return new self($id, $author, $url);
    }

    public function __construct($id, $author, $url)
    {
        $this->id     = $id;
        $this->author = $author;
        $this->url    = $url;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getUrl()
    {
        return $this->url;
    }


}
