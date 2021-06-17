<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class CategoryService
{
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /** @var CategoryRepository */
    private $categoryRepository;
    /** @var PaginatorInterface */
    private $paginator;

    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     * @return PaginationInterface
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
     * @param Category $category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category)
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Usuwa z bazy
     * @param Category $category
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
