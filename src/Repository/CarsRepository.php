<?php

namespace App\Repository;

use App\Entity\Cars;
use App\Entity\Contracts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cars>
 *
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    public function getCarInfoWithContractPricesAndBrand(string $regNumber): mixed
    {
        $query = $this->createQueryBuilder('car')
            ->select('car.model, car.dayprice, car.buyprice, car.reg_number, car.color, car.km, brand.name as brand_name, SUM(contract.price) as total_contract_price')
            ->leftJoin('car.contracts', 'contract') // LEFT JOIN pour inclure également les voitures sans contrats
            ->leftJoin('car.brand', 'brand') // Jointure avec la table Brands pour récupérer le nom de la marque
            ->where('car.reg_number = :regNumber')
            ->setParameter('regNumber', $regNumber)
            ->groupBy('car.id')
            ->getQuery();

        return $query->getResult();
    }

//    /**
//     * @return Cars[] Returns an array of Cars objects
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

//    public function findOneBySomeField($value): ?Cars
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
