<?php

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ContactService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var ContactRepository */
    private $contactRepository;
    /** @var PaginatorInterface */
    private $paginator;

    public function __construct(ContactRepository $contactRepository, PaginatorInterface $paginator)
    {
        $this->contactRepository = $contactRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     * @return PaginationInterface
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
     * @param Contact $contact
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $contact)
    {
        $this->contactRepository->save($contact);
    }

    /**
     * Usuwa z bazy
     * @param Contact $contact
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact)
    {
        $this->contactRepository->delete($contact);
    }
}