<?php
namespace FlorianWolters\Application\UrlShortener\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

/**
 * @Entity
 */
class Trim
{
    /** 
     * @var integer
     *
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="text")
     */
    private $originalUrl;

    /**
     * @var string
     *
     * @Column(type="text")
     */
    private $trimPath;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl($originalUrl)
    {
        $this->originalUrl = $originalUrl;
    }

    public function getTrimPath()
    {
        return $this->trimPath;
    }

    public function setTrimPath($trimPath)
    {
        $this->trimPath = $trimPath;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('originalUrl', new NotBlank);
        $metadata->addPropertyConstraint('originalUrl', new UrlConstraint);

        $metadata->addPropertyConstraint('trimPath', new NotBlank);
        $metadata->addPropertyConstraint('trimPath', new Type('string'));
    }
}
