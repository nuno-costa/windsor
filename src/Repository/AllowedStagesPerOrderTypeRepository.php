<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\AllowedStagesPerOrderType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AllowedStagesPerOrderType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AllowedStagesPerOrderType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AllowedStagesPerOrderType[]    findAll()
 * @method AllowedStagesPerOrderType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllowedStagesPerOrderTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AllowedStagesPerOrderType::class);
    }

    // /**
    //  * @return AllowedStagesPerOrderType[] Returns an array of AllowedStagesPerOrderType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AllowedStagesPerOrderType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
