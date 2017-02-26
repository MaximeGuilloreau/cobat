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
    public function findByIntervale(\DateTime $dateStart, \DateTime $dateEnd)
    {
        $qb = $this
            ->_em->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't')
            ->join('t.worker', 'w')
            ->join('t.site', 's')
            ->addSelect('w')
            ->where('t.date >= :dateStart')
            ->andWhere('t.date < :dateEnd')
            ->groupBy('t.site', 't.id')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ;

        return $qb->getQuery()->getResult();
    }
}
