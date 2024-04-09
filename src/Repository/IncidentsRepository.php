<?php

namespace App\Repository;

use App\Entity\Incidents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Incidents>
 *
 * @method Incidents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidents[]    findAll()
 * @method Incidents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Incidents::class);
    }

//    /**
//     * @return Incidents[] Returns an array of Incidents objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Incidents
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
