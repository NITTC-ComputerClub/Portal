<?php

namespace App\Repository;

use App\Entity\FullName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FullName|null find($id, $lockMode = null, $lockVersion = null)
 * @method FullName|null findOneBy(array $criteria, array $orderBy = null)
 * @method FullName[]    findAll()
 * @method FullName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FullNameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FullName::class);
    }

    // /**
    //  * @return FullName[] Returns an array of FullName objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FullName
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
