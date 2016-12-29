<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Worker
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkerRepository")
 * @ORM\Table(name="cobat_worker")
 */
class Worker
{
    const REPORT = 'report';

    /**
     * @var  integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $id;

    /**
     * @var  string
     * @ORM\Column(type="string")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $firstName;

    /**
     * @var Site[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Site", mappedBy="workers")
     */
    private $sites;

    /**
     * @var Time[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Time", mappedBy="worker")
     * @Groups({Worker::REPORT, "worker_read"})
     */
    private $times;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->times = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setTimes(ArrayCollection $times)
    {
        $this->times = $times;
    }

    public function addTime(Time $time)
    {
        $this->times[] = $time;
    }

    public function getTimes()
    {
        return $this->times;
    }
}

