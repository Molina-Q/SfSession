<?php

namespace App\Repository;

use App\Entity\Programme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programme>
 *
 * @method Programme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programme[]    findAll()
 * @method Programme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programme::class);
    }

//    /**
//     * @return Programme[] Returns an array of Programme objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Programme
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function findProgrammesByTags($session_id) {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $qb->select('t, m, p') /* alias de ce que je veux selectionner*/ 
            ->from('App\Entity\Tag', 't') /* from comme en sql */
            ->leftJoin('t.modules', 'm') /* modules ne prends pas de maj et un s car c'est une collection (car sa rel avec t est ManyToOne) */
            ->leftJoin('m.programmes', 'p') /* idem */
            ->where('p.Session = :id') /* Session prends une maj et n'as pas de S (car sa rel avec p est OneToMany) */
            ->orderBy('t.label, m.label') /* order en priorité par le label de tag puis par le label de module */
            ->setParameter('id', $session_id); /* donne les champs paramétrés */
        
        // $qb->select('p')
        //     ->from('App\Entity\Programme', 'p')
        //     // ->innerJoin('t.modules', 'm')
        //     // ->innerJoin('p.', 'm')
        //     ->leftJoin('p.Module', 'm')
        //     ->leftJoin('m.Tag', 't')
        //     ->where('p.Session = :id')
        //     ->setParameter('id', $session_id);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
