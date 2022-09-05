<?php

namespace App\Lib\Repository;

use App\Lib\Repository\Pagination\HasRepositoryPaginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @extends ServiceEntityRepository
 *
 * @method findOneBy(array $criteria, array $orderBy = null)
 * @method array findAll()
 * @method array findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class ABaseRepository extends ServiceEntityRepository implements IBaseRepository
{
    use HasRepositoryPaginator;

    public function find($id, $lockMode = null, $lockVersion = null){
        try {
            return $this->createQueryBuilder('p')
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->useQueryCache(true)
                //->enableResultCache()
                ->setMaxResults(1)->getOneOrNullResult();
        } catch (NonUniqueResultException $NonUniqueResultException) {
            //TODO handleException
        };
    }

    public function add($entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @throws EntityNotFoundException
     */
    public function removeById($id, bool $flush = true): void
    {
        $entity = $this->find($id);
        if (!$entity) {
            throw new EntityNotFoundException();
        }
        $this->remove($entity, $flush);
    }

    public function remove($entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}