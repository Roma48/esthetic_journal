<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CategoryRepository
 * @package AppBundle\Repository
 */
class CategoryRepository extends EntityRepository
{

    /**
     * @param int $page
     * @return Paginator
     */
    public function getPage($page = 1)
    {
        $limit = 9;
        $query = $this->createQueryBuilder('t')
            ->select('t, image')
            ->leftJoin('t.image', 'image')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit - $limit)
        ;

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }
}