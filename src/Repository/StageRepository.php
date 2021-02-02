<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

     /**
      * @return Stage[] Returns an array of Stage objects
      */

    public function findByDateDepot()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.dateDepot', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Stage[] Returns an array of Stage objects
     */

   public function findByDateDepotDQL()
   {
       // Récupérer le gestionnaire d'entité
       $entityManager = $this->getEntityManager();

       // Construction de la requête sur mesure
       $requete = $entityManager->createQuery(
         'SELECT s, e
          FROM App\Entity\Stage s
          JOIN s.entreprise e
          ORDER BY s.dateDepot DESC'
       );

       // Exécution de la requête et envoi des résultats
       return $requete->execute();
   }


    public function findByDateDepotEntreprise($entreprise)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise', 'e')
            ->andWhere('e.id = :idEntreprise')
            ->setParameter('idEntreprise', $entreprise)
            ->orderBy('s.dateDepot', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Stage[] Returns an array of Stage objects
     */

   public function findByDateDepotFormationDQL($formation)
   {
       // Récupérer le gestionnaire d'entité
       $entityManager = $this->getEntityManager();

       // Construction de la requête sur mesure
       $requete = $entityManager->createQuery(
         'SELECT s, f, e
          FROM App\Entity\Stage s
          JOIN s.formations f
          JOIN s.entreprise e
          WHERE f.id = :formation
          ORDER BY s.dateDepot DESC'
       );

       // Définition de la valeur du paramètre injecté dans la requête
       $requete->setParameter('formation', $formation);

       // Exécution de la requête et envoi des résultats
       return $requete->execute();
   }


    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
