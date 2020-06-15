<?php
namespace EventBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ParticipationRepository extends EntityRepository
{
    public function getParticipation($id)
    {
        $qb=$this->getEntityManager()
            ->createQuery("SELECT p FROM EntityBundle:participation p JOIN p.Event e WHERE e.id_E=?1");
        $qb->setParameter(1,$id);
        return $query=$qb->getResult();
    }
    public function CountParticipation(){
        $query = $this->getEntityManager()->createQuery('
        SELECT e.id_E, e.titre, COUNT(p.id) FROM EventBundle:Event e JOIN e.participation p GROUP BY e.id
     ');
        return $query->getResult();
    }
}
