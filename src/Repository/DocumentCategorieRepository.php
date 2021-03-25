<?php

namespace App\Repository;

use App\Entity\DocumentCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentCategorie[]    findAll()
 * @method DocumentCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentCategorie::class);
    }
}
