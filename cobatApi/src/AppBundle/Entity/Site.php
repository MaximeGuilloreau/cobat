<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Site
 * @ORM\Entity()
 * @ORM\Table()
 */
class Site
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"site_read"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"site_read"})
     */
    private $name;


    /**
     * @var Worker[]
     * @Groups({"site_read"})
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Worker", inversedBy="sites")
     * @ORM\JoinTable(name="sites_workers",
     *     joinColumns={@ORM\JoinColumn(name="site_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="worker_id", referencedColumnName="id")}
     *     )
     */
    private $workers;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="sites")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * Site constructor.
     */
    public function __construct()
    {
        $this->workers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Worker[]
     */
    public function getWorkers()
    {
        return $this->workers;
    }

    /**
     * @param Worker[] $workers
     */
    public function setWorkers($workers)
    {
        $this->workers = $workers;
    }

    /**
     * @param Worker $worker
     */
    public function addWorker(Worker $worker)
    {
        $this->workers[] = $worker;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }
}
