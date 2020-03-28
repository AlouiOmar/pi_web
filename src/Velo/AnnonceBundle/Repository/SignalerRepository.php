<?php
/**
 * Created by PhpStorm.
 * User: Aloui Omar
 * Date: 03/25/2020
 * Time: 19:37
 */

namespace Velo\AnnonceBundle\Repository;
use Doctrine\ORM\EntityRepository;


class SignalerRepository extends EntityRepository
{

    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM AppBundle:Signaler a ORDER BY a.cause ASC'
            )
            ->getResult();
    }

    public function findAllSignaled()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s.ids as id,s.ida')
//            ->addSelect('count(s.ids) as nombre ')
           // ->from('AppBundle:Signaler','sa')
            ->join('s.ida','a')
            ->addSelect('a');
//            ->where('a.active=:query')
//            ->groupBy('s.ida')
//            ->setParameter('query',1);


//        $qb = $this->getEntityManager()
//            ->getRepository('AppBundle:Signaler')
//            ->createQueryBuilder('s')
//            ->select(‌​'s')
//             ->join(‌​'c.children', 'cc')
//            ->addselect(‌​'cc')
//            ->where(‌​'c.parent is NULL')
//        ;



        return $qb->getQuery()
            ->getResult();
    }

    public function countSignaled()
    {
        $qb = $this->createQueryBuilder('s')
            ->join('s.ida','a')
            ->select('a.ida,count(s.ids) as nombre')
//            ->addSelect('count(s.ids) as nombre ')
            // ->from('AppBundle:Signaler','sa')
//            ->join('s.ida','b')
            ->groupBy('s.ida');



        return $qb->getQuery()
            ->getResult();
    }


    public function findCountSignaled()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(s.ids) as nombre, a as annonce FROM AppBundle:Signaler as s JOIN AppBundle:Annonce as a with s.ida=a.ida GROUP BY s.ida'
            )
            ->getResult();
    }

    public function findCause($id)
    {
        $qb = $this->createQueryBuilder('s')
            ->select(' count(s.cause) as nombre, s.cause')
            ->groupBy('s.cause')
            ->where('s.ida=:query')
            ->setParameter('query',$id)
            ->orderBy('nombre ','desc')
        ;

        return $qb->getQuery()
            ->getResult();
    }


}