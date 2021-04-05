<?php

namespace App\Repository;

use App\Entity\Document;
use App\Entity\DocumentCategorie;
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
    /**
     * @var DocumentCategorieRepository
     */
    private $repoDocCateg;

    public function __construct(ManagerRegistry $registry, DocumentCategorieRepository $repoDocCateg)
    {
        parent::__construct($registry, Document::class);
        $this->repoDocCateg = $repoDocCateg;
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

    public function defautCategDocmument(DocumentCategorie $docCateg)
    {
        return $this->createQueryBuilder('d')
            ->update()
            ->where('d.categorie = :idCateg')
            ->setParameter('idCateg', $docCateg->getId())
            ->set('d.categorie', $this->repoDocCateg->findOneBy(['nom' => 'Autre'])->getId())
            ->getQuery()
            ->getResult();
    }
}
