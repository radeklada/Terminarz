<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ContactRepository
 */
class ContactRepository extends ServiceEntityRepository
{
    /**
     * ContactRepository constructor.
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * Query all records.
     * @return \Doctrine\ORM\QueryBuilder Query builder
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
     *
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
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact): void
    {
        $this->_em->remove($contact);
        $this->_em->flush();
    }
}
