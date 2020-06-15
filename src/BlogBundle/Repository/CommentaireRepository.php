<?php

namespace BlogBundle\Repository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{

    public function nbrcommentaire()
    {

        $qb = $this->createQueryBuilder('commentaire')
        ->select('count(commentaire.id)');

        return $qb->getQuery()
                  ->getSingleScalarResult();

      
    }

    public function nbrcommentbypost()
    {
        try
        {
        return  $this->getEntityManager()
        ->createQuery("SELECT COUNT(p.id)  FROM BlogBundle:Commentaire p JOIN BlogBundle:Post d WHERE p.id=d.id GROUP BY p.id")
        ->getOneOrNullResult();
        }
        catch (NonUniqueResultException $e) {
        }
    }

    
    public function rechercheActivecomment($recherche)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('a')
            ->where('a.content like :query or a.posted_at like :query ')
            ->setParameter('query','%'.$recherche.'%')
        ;
        return $qb->getQuery()
            ->getResult();
    }




}
