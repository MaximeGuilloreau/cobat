<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Site;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class WorkerRepository
 */
class WorkerRepository extends EntityRepository
{
    /**
     * @return array
     * @deprecated
     */
    public function findBySite()
    {
        $qb = $this->createQueryBuilder('w')
                ->join('s.workers', 'w');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Site $site
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @return array
     */
    public function reportTime(Site $site, \DateTime $dateStart, \DateTime $dateEnd)
    {
        $qb = $this->createQueryBuilder('w')
                ->addSelect('t')
                ->join('w.sites', 's')
                ->leftJoin('w.times', 't', 'WITH', 't.site = :site AND t.date >= :dateStart AND t.date < :dateEnd')
                ->where('s.id = :site')
                ->setParameter('site', $site->getId())
                ->setParameter('dateStart', $dateStart)
                ->setParameter('dateEnd', $dateEnd)
        ;

        return $qb->getQuery()->getResult();
    }

}
