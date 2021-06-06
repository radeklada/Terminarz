<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * Query all records.
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('contact')
            ->orderBy('contact.id', 'DESC');
    }

    /**
     * Save record.
     * @param \App\Entity\Category $contact Contact entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $contact): void
    {
        $this->_em->persist($contact);
        $this->_em->flush();
    }

    /**
     * Delete record.
     * @param \App\Entity\Contact $contact Contact entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact): void
    {
        $this->_em->remove($contact);
        $this->_em->flush();
    }
}
