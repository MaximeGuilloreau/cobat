<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Time
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TimeRepository")
 * @ORM\Table(name="cobat_time")
 */
class Time
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $date;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $amountHour;

    /**
     * @var Worker
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Worker", inversedBy="times")
     * @ORM\JoinColumn(name="worker_id", referencedColumnName="id")
     */
    private $worker;

    /**
     * @var Site
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Site")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id")
     */
    private $site;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getAmountHour()
    {
        return $this->amountHour;
    }

    /**
     * @param int $amountHour
     */
    public function setAmountHour($amountHour)
    {
        $this->amountHour = $amountHour;
    }

    /**
     * @return Worker
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * @param Worker $worker
     */
    public function setWorker($worker)
    {
        $this->worker = $worker;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param Site $site
     */
    public function setSite(Site $site)
    {
        $this->site = $site;
    }
}
