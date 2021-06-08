<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Query all records.
     * @param array $filters
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $qb = $this
            ->createQueryBuilder('event')
            ->join('event.category', 'category')
            ->orderBy('event.id', 'DESC');

        if(array_key_exists('category_id', $filters) && $filters['category_id'] > 0) {
            $qb->where('event.category = :category_id')
                ->setParameter('category_id', $filters['category_id']);
        }

        return $qb;
    }

    /**
     * Save record.
     * @param \App\Entity\Category $event Event entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }


    /**
     * Delete record.
     * @param \App\Entity\Event $event Event entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Event $event): void
    {
        $this->_em->remove($event);
        $this->_em->flush();
    }
}