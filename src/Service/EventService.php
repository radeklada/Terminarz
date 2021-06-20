<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class EventService
 */
class EventService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var EventRepository */
    private $eventRepository;
    /** @var PaginatorInterface */
    private $paginator;

    /**
     * EventService constructor.
     * @param \App\Repository\EventRepository         $eventRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param array $filters
     * @param int   $page
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPaginatedList(array $filters, int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->queryAll($filters),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Zapisuje do bazy
     * @param \App\Entity\Event $event
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Event $event)
    {
        $this->eventRepository->save($event);
    }

    /**
     * Usuwa z bazy
     * @param \App\Entity\Event $event
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Event $event)
    {
        $this->eventRepository->delete($event);
    }
}
