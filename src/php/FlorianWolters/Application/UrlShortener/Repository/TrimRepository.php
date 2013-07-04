<?php
namespace FlorianWolters\Application\UrlShortener\Repository;

use Doctrine\ORM\EntityRepository;
use FlorianWolters\Application\UrlShortener\Entity\Trim;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 * @see       TrimRepositoryInterface
 * @todo      Find a way to configure the concrete Repository implementation during runtime.
 * @todo      This class should be renamed to "TrimDoctrineRepository" with this implementation.
 */
class TrimRepository extends EntityRepository implements TrimRepositoryInterface
{
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
        $this->getEntityManager()->detach($trim);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function saveTrim(Trim $trim)
    {
        $this->getEntityManager()->persist($trim);

        return $this->getEntityManager()->flush();
    }
}
