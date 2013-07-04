<?php
namespace FlorianWolters\Application\UrlShortener\Entity;

use \DateTime;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 * @todo The current implementation of this class should be reflected by renaming it to "TrimDoctrineEntity".
 * @todo This is not a POPO, and therefore does not follow the Persistence Ignorance (PI) pattern.
 *
 * @Entity(repositoryClass="FlorianWolters\Application\UrlShortener\Repository\TrimRepository")
 * @HasLifecycleCallbacks
 */
class Trim
{
    /**
     * @var integer
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="text", name="original_url", length=2048, unique=true)
     */
    private $originalUrl;

    /**
     * @var string
     *
     * @Column(type="text", name="trim_path", length=32, unique=true)
     */
    private $trimPath;

    /**
     * @var integer
     *
     * @Column(type="integer", name="times_called")
     */
    private $timesCalled = 0;

    /**
     * @var DateTime
     *
     * @Column(type="datetime", name="created_on")
     */
    private $createdOn;

    /**
     * @var string
     *
     * @Column(type="string", name="created_from_ip", length=15)
     */
    private $createdFromIp;

    /**
     * @var integer
     */
    private $trimPathLength;

    /**
     * @param integer $trimPathLength
     */
    public function __construct($trimPathLength)
    {
        $this->trimPathLength = $trimPathLength;
    }

    /**
     * @PrePersist
     */
    public function prePersist()
    {
        $this->setCreatedOn(new DateTime);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return Trim This {@see Trim}.
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    /**
     * @param string $originalUrl
     *
     * @return Trim This {@see Trim}.
     */
    public function setOriginalUrl($originalUrl)
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrimPath()
    {
        return $this->trimPath;
    }

    /**
     * @param string $trimPath
     *
     * @return Trim This {@see Trim}.
     */
    public function setTrimPath($trimPath)
    {
        $this->trimPath = $trimPath;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTimesCalled()
    {
        return $this->timesCalled;
    }

    /**
     * @param integer $timesCalled
     *
     * @return Trim This {@see Trim}.
     */
    public function setTimesCalled($timesCalled)
    {
        $this->timesCalled = $timesCalled;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     *
     * @return Trim This {@see Trim}.
     */
    protected function setCreatedOn(DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedFromIp()
    {
        return $this->createdFromIp;
    }

    /**
     * @param string $createdFromIp
     *
     * @return Trim This {@see Trim}.
     */
    public function setCreatedFromIp($createdFromIp)
    {
        $this->createdFromIp = $createdFromIp;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrimPathLength()
    {
        return $this->trimPathLength;
    }

    /**
     * @param ClassMetadata $metadata
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('originalUrl', new Assert\NotBlank);
        $metadata->addPropertyConstraint('originalUrl', new Assert\Url);
        $metadata->addPropertyConstraint(
            'originalUrl',
            new Assert\Length(array('min' => 6, 'max' => 2048))
        );

        $metadata->addPropertyConstraint('trimPath', new Assert\Type('string'));
        $metadata->addPropertyConstraint(
            'trimPath',
            new Assert\RegEx('/^[A-Z0-9]+$/i')
        );

        $metadata->addPropertyConstraint('timesCalled', new Assert\Type('integer'));
        $metadata->addPropertyConstraint('createdOn', new Assert\DateTime);
        $metadata->addPropertyConstraint('createdFromIp', new Assert\Type('string'));
    }
}
