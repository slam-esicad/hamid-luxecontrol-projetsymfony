<?php

namespace App\Repository;

use App\Entity\Contracts;
use App\Entity\Cars;
use App\Entity\Brands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contracts>
 *
 * @method Contracts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contracts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contracts[]    findAll()
 * @method Contracts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contracts::class);
    }


    /**
     * @return \mixed[][] Retuens an array of top 10 contracts
     */
    public function find10BestRentedCars()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT name, model, reg_number, color, km, price, COUNT(car_id) as 'nb_con', SUM(price) as 'price' FROM `contracts` INNER JOIN `cars` ON car_id = cars.id INNER JOIN `brands` ON cars.brand_id = brands.id GROUP BY car_id ORDER BY SUM(price) DESC LIMIT 10;";

        $stmt = $conn->prepare($sql);

        $r = $stmt->executeQuery();

        return $r->fetchAllAssociative();
    }


    public function find10BestCars()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT name, model, reg_number, color, km, price, COUNT(car_id) as 'nb_con', SUM(price) as 'price' FROM `contracts` INNER JOIN `cars` ON car_id = cars.id INNER JOIN `brands` ON cars.brand_id = brands.id GROUP BY car_id ORDER BY COUNT(car_id) DESC LIMIT 10;";

        $stmt = $conn->prepare($sql);

        $r = $stmt->executeQuery();

        return $r->fetchAllAssociative();
    }

//    /**
//     * @return Contracts[] Returns an array of Contracts objects
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

//    public function findOneBySomeField($value): ?Contracts
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
