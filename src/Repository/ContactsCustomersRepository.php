<?php

namespace App\Repository;

use App\Entity\ContactsCustomers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactsCustomers>
 *
 * @method ContactsCustomers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactsCustomers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactsCustomers[]    findAll()
 * @method ContactsCustomers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactsCustomersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactsCustomers::class);
    }

//    /**
//     * @return ContactsCustomers[] Returns an array of ContactsCustomers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContactsCustomers
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
