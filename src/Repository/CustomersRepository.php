<?php

namespace App\Repository;

use App\Entity\Customers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customers>
 *
 * @method Customers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customers[]    findAll()
 * @method Customers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customers::class);
    }

    public function getCaOfClientFromWord($column, $keyword): mixed
    {
        $query = $this->createQueryBuilder('c')
            ->select('c.name, c.address, c.pro, SUM(ct.price) as total_contract_price')
            ->leftJoin('c.contracts', 'ct')  // Utilisation de LEFT JOIN pour inclure les clients même s'ils n'ont pas de contrats
            ->where('c.' . $column . ' LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')
            ->groupBy('c.id')  // Groupement par l'ID du client pour obtenir une ligne par client
            ->getQuery();

        return $query->getResult();
    }

    /*public function getCAOfCustomer()
    {
        $query = $this->createQueryBuilder('a')
            ->select('id, contract.price')
            ->innerJoin('App\Entity\Contracts', 'contract', 'contract.customer = a.id')
            ->getQuery();

        return $query->getResult();
    }*/

//    /**
//     * @return Customers[] Returns an array of Customers objects
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

//    public function findOneBySomeField($value): ?Customers
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
