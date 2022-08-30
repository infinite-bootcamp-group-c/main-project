<?php

namespace App\Lib\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @extends ServiceEntityRepository
 *
 * @method find($id, $lockMode = null, $lockVersion = null)
 * @method findOneBy(array $criteria, array $orderBy = null)
 * @method array findAll()
 * @method array findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class ABaseRepository extends ServiceEntityRepository implements IBaseRepository
{
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