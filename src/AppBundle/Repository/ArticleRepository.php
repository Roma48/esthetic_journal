<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class ArticleRepository
 * @package AppBundle\Repository
 */
class ArticleRepository extends EntityRepository
{
    /**
     * @param int $page
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPage($page = 1)
    {
        $limit = 9;
        $query = $this->createQueryBuilder('t')
            ->select('t, image, category, user')
            ->leftJoin('t.image', 'image')
            ->leftJoin('t.categories', 'category')
            ->leftJoin('t.users', 'user')
            ->groupBy('t.id')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit - $limit)
        ;

        return $query;
    }

    /**
     * @return array
     */
    public function getSlides()
    {
        $query = $this->createQueryBuilder('a')
            ->select('a, image, category, user')
            ->leftJoin('a.image', 'image')
            ->leftJoin('a.categories', 'category')
            ->leftJoin('a.users', 'user')
            ->groupBy('a.id')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

        return $query;
    }

    /**
     * @param string $slug
     * @param int $page
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByCategory($slug = '', $page = 1)
    {
        $limit = 9;
        $query = $this->createQueryBuilder('t')
            ->select('t, image, category, user')
            ->leftJoin('t.image', 'image')
            ->leftJoin('t.categories', 'category')
            ->leftJoin('t.users', 'user')
            ->where('category.slug = ?1')
            ->setParameter(1, $slug)
            ->groupBy('t.id')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit - $limit)
        ;

        return $query;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lastArticles($limit)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p, image, category, user')
            ->leftJoin('p.image', 'image')
            ->leftJoin('p.categories', 'category')
            ->leftJoin('p.users', 'user')
            ->groupBy('p.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;

        return $query;
    }

    /**
     * @param $text
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function searchArticles($text)
    {
        $query = $this->createQueryBuilder('a');
        $query->select('a, image, category, user')
            ->leftJoin('a.image', 'image')
            ->leftJoin('a.categories', 'category')
            ->leftJoin('a.users', 'user')
            ->groupBy('a.id')
            ->where($query->expr()->like('a.title', ':text'))
            ->orWhere($query->expr()->like('a.content', ':text'))
            ->orWhere($query->expr()->like('a.description', ':text'))
            ->setParameter('text', '%' . $text . '%')
            ->getQuery()
            ->getResult()
        ;

        return $query;
    }
}