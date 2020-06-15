<?php
namespace EventBundle\Repository;
use Doctrine\ORM\EntityRepository;
use EventBundle\Entity\Event;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;


class EventRepository extends EntityRepository
{
    public function cherchertitre($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM EventBundle:Event e
                WHERE e.titre LIKE :str'

            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

}
