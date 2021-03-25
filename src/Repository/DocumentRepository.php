<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function allDocument(): array
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->join('d.evenement', 'e')
            ->join('d.categorie', 'dc')
            ->where('e.id = d.evenement')
            ->where('dc.id = d.categorie')
            ->getQuery()
            ->getResult();
    }

    public function countDocument(): array
    {
        return $this->createQueryBuilder('d')
            ->select('count(d.evenement), e.id')
            ->join('d.evenement', 'e')
            ->where('e.id = d.evenement')
            ->groupBy('d.evenement')
            ->getQuery()
            ->getResult();
    }
}
