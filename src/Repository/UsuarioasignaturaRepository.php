<?php

namespace App\Repository;

use App\Entity\Usuarioasignatura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Usuarioasignatura|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuarioasignatura|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuarioasignatura[]    findAll()
 * @method Usuarioasignatura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioasignaturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuarioasignatura::class);
    }

    // /**
    //  * @return Usuarioasignatura[] Returns an array of Usuarioasignatura objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usuarioasignatura
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
