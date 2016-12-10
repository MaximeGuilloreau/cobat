<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Site;
use Doctrine\ORM\EntityRepository;

class WorkerRepository extends EntityRepository
{
    public function findBySite()
    {
        $qb = $this->createQueryBuilder('w')
                ->join('s.workers', 'w');

        return $qb->getQuery()->getResult();
    }

    public function reportTime(Site $site)
    {
        $qb = $this->createQueryBuilder('w')
                ->select('w')
                ->addSelect('t')
                ->join('w.sites', 's')
                ->leftJoin('w.times', 't')
                ->where('s.id = :site')
                ->andWhere('t.site = :site')
                ->setParameter('site', $site->getId());

        return $qb->getQuery()->getResult();
    }

}
