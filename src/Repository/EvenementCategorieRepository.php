<?php

namespace App\Repository;

use App\Entity\EvenementCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvenementCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvenementCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvenementCategorie[]    findAll()
 * @method EvenementCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvenementCategorie::class);
    }

    // /**
    //  * @return EvenementCategorie[] Returns an array of EvenementCategorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvenementCategorie
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
