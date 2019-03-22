<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getJsonStatsNationales($dateDebut, $dateFin)
    {

        $qb = $this->createQueryBuilder('u')
            ->Where('u.date_first_seen > :dateDebut')
            ->setParameter('dateDebut', $dateDebut)
            ->andWhere('u.date_first_seen < :dateFin')
            ->setParameter('dateFin', $dateFin);

        $results = $qb->getQuery()->getResult();

        return $results;
    }
    /**
     * @return Article[] Returns an array of Departement objects
     */
    public function getStatsByDate($dateDebut, $dateFin)
    {

        $qb = $this->createQueryBuilder('u')
            ->Where('u.date_first_seen > :dateDebut')
            ->setParameter('dateDebut', $dateDebut)
            ->andWhere('u.date_first_seen < :dateFin')
            ->setParameter('dateFin', $dateFin);


        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getStatsByYear($year)
    {

        $qb = $this->createQueryBuilder('u')
            ->Where('date_trunc(\'year\',u.date_first_seen) = :year')
            ->setParameter('year', $year);

        return $results = $qb->getQuery()->getResult();

    }
    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getStatsByYearMonth($year,$month)
    {

        $qb = $this->createQueryBuilder('u')
            ->Where('date_trunc(\'year\',u.date_first_seen) = :year')
            ->andWhere('date_trunc(\'month\',u.date_first_seen) = :month')
            ->setParameter('year', $year)
            ->setParameter('month', $month);

        return $results = $qb->getQuery()->getResult();
    }

}
