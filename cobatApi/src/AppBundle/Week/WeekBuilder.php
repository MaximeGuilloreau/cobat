<?php

namespace AppBundle\Week;

use AppBundle\Entity\Site;
use AppBundle\Entity\Time;
use AppBundle\Repository\TimeRepository;
use AppBundle\Repository\WorkerRepository;

/**
 * Build week
 * TODO: add explicit documentation
 */
class WeekBuilder
{
    /** @var TimeRepository */
    private $timeRepository;

    /** @var WorkerRepository */
    private $workerRepository;

    /**
     * @param TimeRepository $timeRepository
     */
    public function __construct(TimeRepository $timeRepository, WorkerRepository $workerRepository)
    {
        $this->timeRepository = $timeRepository;
        $this->workerRepository = $workerRepository;
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
        return $this->workerRepository->reportTime($site, $startDate, $endDate);
    }

}
