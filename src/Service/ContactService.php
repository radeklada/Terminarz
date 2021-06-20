<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ContactService
 */
class ContactService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var ContactRepository */
    private $contactRepository;
    /** @var PaginatorInterface */
    private $paginator;

    /**
     * ContactService constructor.
     * @param \App\Repository\ContactRepository       $contactRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator
     */
    public function __construct(ContactRepository $contactRepository, PaginatorInterface $paginator)
    {
        $this->contactRepository = $contactRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     *
     * @return Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contactRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Zapisuje do bazy
     * @param \App\Entity\Contact $contact
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $contact)
    {
        $this->contactRepository->save($contact);
    }

    /**
     * Usuwa z bazy
     * @param \App\Entity\Contact $contact
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact)
    {
        $this->contactRepository->delete($contact);
    }
}
