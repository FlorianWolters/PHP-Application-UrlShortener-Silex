<?php
namespace FlorianWolters\Application\UrlShortener\Service;

use FlorianWolters\Application\UrlShortener\Entity\Trim;
use FlorianWolters\Application\UrlShortener\Repository\TrimRepositoryInterface;
use FlorianWolters\Component\Core\RandomStringUtils;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 * @see       TrimServiceInterface
 */
class TrimService implements TrimServiceInterface
{
    /**
     * @var TrimRepositoryInterface
     */
    private $repository;

    /**
     * @var QrCodeGeneratorService
     */
    private $qrCodeGenerator;

    /**
     * Constructs a new {@see TrimService} with the specified *Repository* and
     * the specified Quick Response (QR) Code generator.
     *
     * @param TrimRepositoryInterface $repository
     * @param QrCodeGeneratorService  $qrCodeGenerator
     */
    public function __construct(
        TrimRepositoryInterface $repository,
        QrCodeGeneratorService $qrCodeGenerator
    ) {
        $this->repository = $repository;
        $this->qrCodeGenerator = $qrCodeGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function countAllTrims()
    {
        return \count($this->findAllTrims());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteTrim(Trim $trim)
    {
        $this->repository->deleteTrim($trim);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllTrims()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findTrimByOriginalUrl($originalUrl)
    {
        return $this->repository->findOneByOriginalUrl($originalUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function findTrimByTrimPath($trimPath)
    {
        return $this->repository->findOneByTrimPath($trimPath);
    }

    /**
     * {@inheritdoc}
     */
    public function saveTrim(Trim $trim)
    {
        do {
            $trimPath = RandomStringUtils::randomAlphanumeric(
                $trim->getTrimPathLength()
            );
        } while (null !== $this->repository->findOneByTrimPath($trimPath));

        $trim->setTrimPath($trimPath);
        $this->repository->saveTrim($trim);

        // TODO Add exception handling.
        $this->qrCodeGenerator->saveQrCodeImageFileForTrim($trim);
    }

    /**
     * {@inheritdoc}
     */
    public function updateTrim(Trim $trim)
    {
        $trim->setTimesCalled(($trim->getTimesCalled() + 1));

        return $this->repository->saveTrim($trim);
    }
}
