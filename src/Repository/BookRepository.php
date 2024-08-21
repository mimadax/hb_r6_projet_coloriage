<?php

namespace App\Repository;

use App\Entity\Book;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

class BookRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Book::class);
        $this->paginator = $paginator;
    }

    public function findBySearch(SearchData $searchData)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        if (!empty($searchData->q)) {
            $queryBuilder = $queryBuilder
                ->andWhere('b.title LIKE :q')
                ->setParameter('q', '%' . $searchData->q . '%');
        }

        $query = $queryBuilder->getQuery();

        return $this->paginator->paginate($query, $searchData->page, 9);
    }
}
