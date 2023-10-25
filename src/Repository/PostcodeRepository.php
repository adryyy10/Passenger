<?php

namespace App\Repository;

use App\Entity\Postcode;
use App\Interface\PostcodeSearchInterface;
use App\Interface\PostcodeSearchNearbyInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Postcode>
 *
 * @method Postcode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postcode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postcode[]    findAll()
 * @method Postcode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostcodeRepository extends ServiceEntityRepository implements PostcodeSearchInterface, PostcodeSearchNearbyInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postcode::class);
    }

    public function findByPartialString(string $postcode): array
    {
        $qb = $this->createQueryBuilder('p');

        $qb->where(
            $qb->expr()->like('p.name', ':postcode')
        )->setParameter('postcode', '%' . $postcode . '%');

        return $qb->getQuery()->getResult();
    }

    public function findNearbyPostcodes(
        float $latitude, 
        float $longitude, 
        int $distance
    ): array {
        $qb = $this->createQueryBuilder('p');

        // Haversine formula
        $qb->addSelect(
            '(6371 * acos(cos(radians(:latitude)) * cos(radians(p.latitude)) * cos(radians(p.longitude) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(p.latitude)))) AS distance'
        );
        
        // Set parameters for latitude, longitude, and distance
        $qb->setParameter('latitude', $latitude);
        $qb->setParameter('longitude', $longitude);
        $qb->setParameter('distance', $distance);
    
        // Filter the results to include only postcodes within the specified distance
        $qb->having('distance <= :distance');
    
        return $qb->getQuery()->getResult();
    }
}
