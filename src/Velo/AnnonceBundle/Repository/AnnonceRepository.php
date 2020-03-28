<?php
/**
 * Created by PhpStorm.
 * User: Aloui Omar
 * Date: 03/21/2020
 * Time: 23:21
 */

namespace Velo\AnnonceBundle\Repository;
use Doctrine\ORM\EntityRepository;


class AnnonceRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM AppBundle:Annonce a ORDER BY a.titre ASC'
            )
            ->getResult();
    }

    public function findAllActive()
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=:query')
            ->setParameter('query',1);
        return $qb->getQuery()
            ->getResult();
    }
    public function findAllMyAnnonces($id)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('u.id=:query')
            ->setParameter('query',$id);
        return $qb->getQuery()
            ->getResult();
    }

    public function getAnnonce($id)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.ida=:query')
            ->setParameter('query',$id);
        return $qb->getQuery()
            ->getResult();


    }

    public function findCategorieActive($categorie)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=1 and a.categorie=:query')
            ->setParameter('query',$categorie);
        return $qb->getQuery()
            ->getResult();
    }

    public function findTypeVeloActive($typeVelo)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=1 and a.typevelo=:query')
            ->setParameter('query',$typeVelo);
        return $qb->getQuery()
            ->getResult();
    }


    public function triPrixActive($choix)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=1')
            ->orderBy('a.prix',$choix);
        return $qb->getQuery()
            ->getResult();
    }


    public function triDateActive()
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=1')
            ->orderBy('a.datep','desc');
        return $qb->getQuery()
            ->getResult();
    }


    public function rechercheActive($recherche)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=1 and (a.titre like :query or a.description like :query or a.prix like :query or a.categorie like :query or a.type like :query)')
            ->setParameter('query','%'.$recherche.'%')

        ;

        return $qb->getQuery()
            ->getResult();
    }

    public function rechercheTypeActive($type)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.idu','u')
            ->addSelect('u')
            ->where('a.active=1 and a.type=:query')
            ->setParameter('query',$type);
        return $qb->getQuery()
            ->getResult();
    }


}