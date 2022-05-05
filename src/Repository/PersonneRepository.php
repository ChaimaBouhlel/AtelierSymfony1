<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Personne $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Personne $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */

    public function findPersonnesByAgeInterval($ageMin, $ageMax)
    {
        $qb = $this->createQueryBuilder('p');
        $this->addAgeInterval($qb,$ageMin,$ageMax);
        return $qb->orderBy('p.age', 'ASC')->getQuery()->getResult();
    }
    public function statsPersonnesByAgeInterval($ageMin, $ageMax)
    {
        $qb = $this->createQueryBuilder('p');
        $this->addAgeInterval($qb,$ageMin,$ageMax);
        $qb->select('avg(p.age) as ageMoyen, count(p.id) as nbrePersonnes');
        return $qb->getQuery()->getScalarResult();
    }
    public function addAgeInterval(QueryBuilder $qb, $ageMin, $ageMax){
        $qb->andWhere('p.age >= :ageMin and p.age <= :ageMax')
            ->setParameters(['ageMin' => $ageMin, 'ageMax' => $ageMax]);
    }

    /*
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
