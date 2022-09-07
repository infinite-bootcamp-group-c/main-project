<?php

namespace App\Lib\Repository;

interface IBaseRepository
{
    public function add($entity, bool $flush = false): void;

    public function remove($entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, array $orderBy = null);

    public function findAll();

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}