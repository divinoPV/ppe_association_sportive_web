<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function searchEvenement(Evenement $criteria): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.sport', 's')
            ->join('e.categorie', 'ec')
            ->where('s.nom = :sport')
            ->setParameter('sport', $criteria->getSport()->getNom())
            ->andWhere('ec.nom = :cat')
            ->setParameter('cat', $criteria->getCategorie()->getNom())
            ->andWhere('e.actif = :actif')
            ->setParameter('actif', $criteria->getActif())
            ->getQuery()
            ->getResult();
    }

    public function countEvent(): array
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id)')
            ->getQuery()
            ->getResult();
    }

    public function lastEvenements(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.debuterLe', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
