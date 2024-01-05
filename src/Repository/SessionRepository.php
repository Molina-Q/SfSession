<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findTags($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findIncomingSessions() {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $dateNow = new \DateTime('now');

        $qb->select('se') /* alias de ce que je veux selectionner*/ 
            ->from('App\Entity\Session', 'se') /* from comme en sql */
            ->where('se.dateStart > :date') /* Session prends une maj et n'as pas de S (car sa rel avec p est OneToMany) */
            ->orderBy('se.dateStart', 'DESC')
            ->setParameter('date', $dateNow); /* donne les champs paramétrés */

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findPassedSessions() {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $dateNow = new \DateTime('now');

        $qb->select('se') /* alias de ce que je veux selectionner*/ 
            ->from('App\Entity\Session', 'se') /* from comme en sql */
            ->where('se.dateStart < :date') /* Session prends une maj et n'as pas de S (car sa rel avec p est OneToMany) */
            ->orderBy('se.dateStart', 'DESC')
            ->setParameter('date', $dateNow); /* donne les champs paramétrés */

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
