<?php

namespace App\Repository;

use App\Entity\Module;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Module>
 *
 * @method Module|null find($id, $lockMode = null, $lockVersion = null)
 * @method Module|null findOneBy(array $criteria, array $orderBy = null)
 * @method Module[]    findAll()
 * @method Module[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Module::class);
    }

//    /**
//     * @return Module[] Returns an array of Module objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Module
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findUnusedModule($session_id) {
    $em = $this->getEntityManager();
    $sub = $em->createQueryBuilder();

    $qb = $sub;

    $qb->select('m')
        ->from('App\Entity\Module', 'm')
        ->leftJoin('m.programmes', 'p')
        ->where('p.Session = :id');

    $sub = $em->createQueryBuilder();
    // sub query ou je recherche tous les student qui ne sont pas reliés à la session actuelle
    $sub->select('mo')
        ->from('App\Entity\Module', 'mo')
        ->where($sub->expr()->notIn('mo.id', $qb->getDQL()))
        ->setParameter('id', $session_id)
        ->orderBy('mo.label');

    $query = $sub->getQuery();
    return $query->getResult();
}
}
