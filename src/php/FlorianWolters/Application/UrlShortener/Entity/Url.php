<?php
namespace FlorianWolters\Application\UrlShortener\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('originalUrl', new NotBlank);
        $metadata->addPropertyConstraint('originalUrl', new UrlConstraint);

        $metadata->addPropertyConstraint('trimmedUrl', new NotBlank);
        $metadata->addPropertyConstraint('trimmedUrl', new Type('string'));
    }
}
