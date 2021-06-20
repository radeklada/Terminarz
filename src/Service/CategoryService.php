<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CategoryService
 */
class CategoryService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var CategoryRepository */
    private $categoryRepository;
    /** @var PaginatorInterface */
    private $paginator;

    /**
     * CategoryService constructor.
     * @param \App\Repository\CategoryRepository      $categoryRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Zapisuje do bazy
     * @param \App\Entity\Category $category
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category)
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Usuwa z bazy
     * @param \App\Entity\Category $category
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Category $category)
    {
        $this->categoryRepository->delete($category);
    }

    /**
     * @return array
     */
    public function getNamesForFormFilter()
    {
        return $this->categoryRepository->getNamesForFormFilter();
    }
}
