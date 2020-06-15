<?php
namespace EventBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getParticipants(){
        $query = $this->getEntityManager()->createQuery('
        SELECT u.id,u.username, COUNT(u.id),e.id FROM EventBundle:User, EventBundle:Event e WHERE u.id=u.participer.user_id AND e.id=participer.event_id
     ');
        return $query->getResult();
    }
}
