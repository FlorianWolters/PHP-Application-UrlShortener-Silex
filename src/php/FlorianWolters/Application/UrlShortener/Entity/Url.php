<?php
namespace FlorianWolters\Application\UrlShortener\Entity;

class Url
{
    private $originalUrl;

    private $trimmedUrl;

    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl($originalUrl)
    {
        $this->originalUrl = $originalUrl;
    }

    public function getTrimmedUrl()
    {
        return $this->trimmedUrl;
    }

    public function setTrimmedUrl($trimmedUrl)
    {
        $this->trimmedUrl = $trimmedUrl;
    }
}
