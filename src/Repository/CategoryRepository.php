<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('category')
            ->orderBy('category.name', 'ASC');
    }

    /**
     * Save record.
     * @param \App\Entity\Category $category Category entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category): void
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }

    /**
     * Delete record.
     * @param \App\Entity\Category $category Category entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Category $category): void
    {
        $this->_em->remove($category);
        $this->_em->flush();
    }

    /**
     * @return array
     */
    public function getNamesForFormFilter()
    {
        $result = ['' => null];

        $records = $this
            ->createQueryBuilder('category')
            ->select('category.id, category.name')
            ->orderBy('category.name', 'ASC')
            ->getQuery()
            ->getArrayResult();
        ;

        foreach ($records as $rec) {
            $result[$rec['name']] = $rec['id'];
        }

        return $result;
    }
}
