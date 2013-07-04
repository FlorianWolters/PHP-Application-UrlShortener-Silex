<?php
namespace FlorianWolters\Application\UrlShortener\Repository;

use FlorianWolters\Application\UrlShortener\Entity\Trim;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
interface TrimRepositoryInterface
{
    /**
     * @return integer
     */
    public function countAllTrims();
    
    /**
     * @param Trim $trim
     *
     * @return void
     */
    public function deleteTrim(Trim $trim);
    
    /**
     * @param Trim $trim
     *
     * @return Trim
     */
    public function saveTrim(Trim $trim);
}
