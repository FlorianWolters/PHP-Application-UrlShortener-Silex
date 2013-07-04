<?php
namespace FlorianWolters\Application\UrlShortener\Service;

use FlorianWolters\Application\UrlShortener\Entity\Trim;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
interface TrimServiceInterface
{
    /**
     * @return integer The number of {@see Trim} objects.
     */
    public function countAllTrims();

    /**
     * @param Trim $trim The {@see Trim} to delete.
     *
     * @return void
     */
    public function deleteTrim(Trim $trim);

    /**
     * @return Trim[] All {@see Trim} objects.
     */
    public function findAllTrims();

    /**
     * @param string $originalUrl
     *
     * @return Trim|null
     */
    public function findTrimByOriginalUrl($originalUrl);

    /**
     * @param string $trimPath
     *
     * @return Trim|null
     */
    public function findTrimByTrimPath($trimPath);

    /**
     * @param Trim $trim The {@see Trim} to insert.
     *
     * @return void
     */
    public function saveTrim(Trim $trim);

    /**
     * @param Trim $trim The {@see Trim} to update.
     *
     * @return Trim
     */
    public function updateTrim(Trim $trim);
}
