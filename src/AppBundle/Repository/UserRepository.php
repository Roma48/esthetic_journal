<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class UserRepository
 * @package AppBundle\Repository
 */
class UserRepository extends EntityRepository
{

    /**
     * @param $slug
     * @return Paginator
     */
    public function getPage($page)
    {
        $limit = 9;
        $query = $this->createQueryBuilder('user')
            ->select('user')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit - $limit)
        ;

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }
}