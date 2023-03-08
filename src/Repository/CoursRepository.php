<?php

namespace App\Repository;

use App\Entity\Cours;
use App\Entity\Matiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 *
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function save(Cours $entity,  Matiere $matiere, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cours $entity, Matiere $matiere,  bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Cours[] Returns an array of Cours objects that match the same day as $date
     */
    public function findByDateField($date): array
    {
        return $this->createQueryBuilder('cours')
            ->andWhere('DAY(cours.dateHeureDebut) = DAY(:date)')
            ->andWhere('MONTH(cours.dateHeureDebut) = MONTH(:date)')
            ->andWhere('YEAR(cours.dateHeureDebut) = YEAR(:date)')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Cours
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
