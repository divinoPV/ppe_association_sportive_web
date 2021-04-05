<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function get_class;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * @var CategorieRepository
     */
    private $repoCateg;

    public function __construct(ManagerRegistry $registry, CategorieRepository $repoCateg)
    {
        parent::__construct($registry, User::class);
        $this->repoCateg = $repoCateg;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User):
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        endif;

        $user->setPassword($newEncodedPassword);

        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findUserByRole($role)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"' . $role . '"%');

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function defautCategUtilisateur(Categorie $categ)
    {
        return $this->createQueryBuilder('u')
            ->update()
            ->where('u.categorie = :idCateg')
            ->setParameter('idCateg', $categ->getId())
            ->set('u.categorie', $this->repoCateg->findOneBy(['nom' => 'Autre'])->getId())
            ->getQuery()
            ->getResult();
    }
}
