<?php
namespace FlorianWolters\Application\UrlShortener\Service;

use FlorianWolters\Application\UrlShortener\Entity\Trim;
use FlorianWolters\Component\Service\QuickResponse\QrCodeParameter;
use FlorianWolters\Component\Service\QuickResponse\QrServiceInterface;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
class QrCodeGeneratorService
{
    /**
     * @var QrServiceInterface
     */
    private $qrService;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @param QrServiceInterface $qrService
     * @param string             $basePath
     */
    public function __construct(
        QrServiceInterface $qrService,
        $basePath
    ) {
        $this->qrService = $qrService;
        $this->basePath = $basePath;
    }

    /**
     * @param Trim $trim
     *
     * @return void
     */
    public function saveQrCodeImageFileForTrim(Trim $trim)
    {
        // TODO Remove hardcoded dependency. Use configuration parameters.
        $qrCodeParameter = new QrCodeParameter($trim->getOriginalUrl());
        $filePath = $this->qrCodeFilePath($trim);
        $fileContent = $this->qrService->getQrCode($qrCodeParameter);
        \file_put_contents($filePath, $fileContent);
    }

    /**
     * @param Trim $trim
     *
     * @return string
     */
    private function qrCodeFilePath(Trim $trim)
    {
        return $this->basePath . '/' . $trim->getId() . '.png';
    }
}
