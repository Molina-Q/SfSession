<?php

namespace App\Repository;

use App\Entity\RegisterSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegisterSession>
 *
 * @method RegisterSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegisterSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegisterSession[]    findAll()
 * @method RegisterSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegisterSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegisterSession::class);
    }

//    /**
//     * @return RegisterSession[] Returns an array of RegisterSession objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RegisterSession
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
