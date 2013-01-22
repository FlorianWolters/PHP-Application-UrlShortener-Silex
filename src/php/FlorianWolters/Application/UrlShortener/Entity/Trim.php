<?php
namespace FlorianWolters\Application\UrlShortener\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

        return $this;
    }

    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl($originalUrl)
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getTrimPath()
    {
        return $this->trimPath;
    }

    public function setTrimPath($trimPath)
    {
        $this->trimPath = $trimPath;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('originalUrl', new Assert\NotBlank);
        $metadata->addPropertyConstraint('originalUrl', new Assert\Url);
        $metadata->addPropertyConstraint(
            'originalUrl',
            new Assert\Length(['min' => 6, 'max' => 255])
        );

        $metadata->addPropertyConstraint('trimPath', new Assert\NotBlank);
        $metadata->addPropertyConstraint('trimPath', new Assert\Type('string'));
        $metadata->addPropertyConstraint(
            'trimPath',
            new Assert\Length(['min' => 3, 'max' => 30])
        );
        $metadata->addPropertyConstraint(
            'trimPath',
            new Assert\RegEx('/^[a-z0-9\-\_]+$/')
        );
    }
}
