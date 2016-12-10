<?php

namespace AppBundle\Export;

use AppBundle\Entity\Time;
use AppBundle\Repository\TimeRepository;

/**
 * Class ExportBuilder
 */
class ExportBuilder
{
    /**
     * @var TimeRepository
     */
    private $timeRepository;

    public function __construct(TimeRepository $timeRepository)
    {
        $this->timeRepository = $timeRepository;
    }

    /**
     * @param integer $year
     * @param integer $month
     * @return array
     */
    public function build($year, $month)
    {
        $start = $this->getStartIntervale($year, $month);
        $end = $this->getEndIntervale($start);
        $rangeDays = $this->rangeDays($start, $end);
        $header = $this->getHeader($rangeDays);
        $times = $this->timeRepository->findByIntervale($start, $end);
        $reports = $this->formatTimes($times);
        $reports = $this->computeMissingDays($reports, $rangeDays);

        return [$header, $reports];
    }

    /**
     * @param integer $year
     * @param integer $month
     * @return $this
     */
    private function getStartIntervale($year, $month)
    {
        return (new \DateTime())
            ->setDate($year, $month, 1)
            ->setTime(0, 0, 0);
    }

    /**
     * @param \DateTime $start
     * @return \DateTime
     */
    private function getEndIntervale(\DateTime $start)
    {
        $end = clone $start;
        $end->modify('+1 month');

        return $end;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    private function rangeDays(\DateTime $start, \DateTime $end)
    {
        $range = [];
        $dateStart = clone $start;

        while($dateStart->format('m') !== $end->format('m')) {
            $range[] = clone $dateStart;
            $dateStart->modify('+1 day');
        }

        return $range;
    }

    /**
     * @param \DateTime[] $rangeDays
     * @return array
     */
    private function getHeader(array $rangeDays)
    {
//        $days = array_map(function ($day) {
//            return $day->format('d');
//        }, $rangeDays);

        $staticHeader = [
            'Nom',
            'Prénom',
            'Chantier'
        ];

        return array_merge($staticHeader, $rangeDays);
    }

    /**
     * @param Time[] $times
     * @return array
     */
    private function formatTimes($times)
    {
        $data = [];

        /** @var Time $time */
        foreach ($times as $time) {
            if (!isset($data[$time->getWorker()->getId()])) {
                $data[$time->getWorker()->getId()] = [
                    'name' => $time->getWorker()->getName(),
                    'firstname' => $time->getWorker()->getFirstName(),
                    'site' => 'site',
                    'times' => [],
                    'totalHour' => 0,
                ];
            }

            $data[$time->getWorker()->getId()]['times'][$time->getDate()->format('d/m/y')] = [
                'date' => $time->getDate(),
                'amount' => $time->getAmountHour(),
            ];

            $data[$time->getWorker()->getId()]['totalHour'] += $time->getAmountHour();
        }

        return $data;
    }

    private function computeMissingDays($workerReports, $rangeDays)
    {
        foreach ($workerReports as &$report) {
            foreach($rangeDays as $day) {
                if(!isset($report['times'][$day->format('d/m/y')])) {
                    $report['times'][$day->format('d/m/y')] = [
                        'date' => $day,
                        'amount' => 0,
                    ];
                }
            }
        }

        return $workerReports;
    }
}
