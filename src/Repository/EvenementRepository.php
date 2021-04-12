<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Sport;
use App\Entity\Type;
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
    /**
     * @var TypeRepository
     */
    private $repoType;
    /**
     * @var SportRepository
     */
    private $repoSport;
    /**
     * @var CategorieRepository
     */
    private $repoCateg;

    public function __construct(ManagerRegistry $registry, TypeRepository $repoType, SportRepository $repoSport, CategorieRepository $repoCateg)
    {
        parent::__construct($registry, Evenement::class);

        $this->repoType = $repoType;
        $this->repoSport = $repoSport;
        $this->repoCateg = $repoCateg;
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

    public function countEventActif(bool $actif = true): array
    {
        $actif === true
            ? $actif = 1
            : $actif = 0
        ;

        return $this->createQueryBuilder('e')
            ->select('count(e.id)')
            ->where('e.actif LIKE :actif')
            ->setParameter('actif', $actif)
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

    public function defautTypeEvenement(Type $type)
    {
        return $this->createQueryBuilder('e')
            ->update()
            ->where('e.type = :idType')
            ->setParameter('idType', $type->getId())
            ->set('e.type', $this->repoType->findOneBy(['nom' => 'Autre'])->getId())
            ->getQuery()
            ->getResult();
    }

    public function defautSportEvenement(Sport $sport)
    {
        return $this->createQueryBuilder('e')
            ->update()
            ->where('e.sport = :idSport')
            ->setParameter('idSport', $sport->getId())
            ->set('e.sport', $this->repoSport->findOneBy(['nom' => 'Autre'])->getId())
            ->getQuery()
            ->getResult();
    }

    public function defautCategEvenement(Categorie $categ)
    {
        return $this->createQueryBuilder('e')
            ->update()
            ->where('e.categorie = :idCateg')
            ->setParameter('idCateg', $categ->getId())
            ->set('e.categorie', $this->repoCateg->findOneBy(['nom' => 'Autre'])->getId())
            ->getQuery()
            ->getResult();
    }
}
