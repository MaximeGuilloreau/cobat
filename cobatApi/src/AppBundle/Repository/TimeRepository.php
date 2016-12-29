<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Site;
use Doctrine\ORM\EntityRepository;

/**
 * Class TimeRepository
 */
class TimeRepository extends EntityRepository
{
    /**
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @return array
     */
    public function findByIntervale(Site $site,\DateTime $dateStart, \DateTime $dateEnd)
    {
        $qb = $this
            ->_em->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't')
            ->join('t.worker', 'w')
            ->addSelect('w')
            ->where('t.date >= :dateStart')
            ->andWhere('t.date < :dateEnd')
            ->andWhere('t.site = :site')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->setParameter('site', $site)
            ;

        return $qb->getQuery()->getResult();
    }
}
