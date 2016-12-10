<?php

namespace AppBundle\Week;

use AppBundle\Entity\Site;
use AppBundle\Repository\TimeRepository;

/**
 * Build week
 * TODO: add explicit documentation
 */
class WeekBuilder
{
    /** @var TimeRepository */
    private $timeRepository;

    /**
     * @param TimeRepository $timeRepository
     */
    public function __construct(TimeRepository $timeRepository)
    {
        $this->timeRepository = $timeRepository;
    }

    /**
     * @param Site      $site
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return array
     */
    public function build(Site $site, \DateTime $startDate, \DateTime $endDate)
    {
        $times = $this->timeRepository->findByIntervale($site, $startDate, $endDate);

        return $times;
    }

}
