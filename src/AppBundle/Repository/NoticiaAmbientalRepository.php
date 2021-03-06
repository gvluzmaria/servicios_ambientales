<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NoticiaAmbientalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoticiaAmbientalRepository extends EntityRepository
{
    public function findTop10NoticiasAmbientales()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT s FROM AppBundle:NoticiaAmbiental s ORDER BY s.fechaPublicacion DESC'
        )->setMaxResults(10)->getResult();
    }
}