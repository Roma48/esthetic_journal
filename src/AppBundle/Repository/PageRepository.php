<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PageRepository
 * @package AppBundle\Repository
 */
class PageRepository extends EntityRepository
{
    /**
     * @param int $page
     * @return Paginator
     */
    public function getPage($page = 1)
    {
        $limit = 9;
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit - $limit)
        ;

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }
}