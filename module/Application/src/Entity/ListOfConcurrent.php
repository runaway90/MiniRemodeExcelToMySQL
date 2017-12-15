<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="list_of_concurrent")
 */
class ListOfConcurrent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string", name="name_pre")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="ingrid")
     */
    protected $ingrid;

    /**
     * @ORM\Column(type="string", name="name_concurrent")
     */
    protected $name_concurrent;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIngrid()
    {
        return $this->ingrid;
    }

    public function setIngrid($ingrid)
    {
        $this->ingrid = $ingrid;
    }

    public function getNameConcurrent()
    {
        return $this->name_concurrent;
    }

    public function setNameConcurrent($name_concurrent)
    {
        $this->name_concurrent = $name_concurrent;
    }

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\ListOfMedicament", inversedBy="$name")
     * @ORM\JoinTable(name="med_and_conc",
     *      joinColumns={@ORM\JoinColumn(name="name", referencedColumnName="name_pre")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="name", referencedColumnName="name")}
     *      )
     */
    protected $listOfMedicament;

    public function __construct()
    {
        $this->listOfMedicament = new ArrayCollection();
    }

    public function getListOfMedicament()
    {
        return $this->listOfMedicament;
    }

    public function addListOfMedicament($addMedicament)
    {
        $this->listOfMedicament[] = $addMedicament;
    }

    public function removeListOfMedicament($removeMedicament)
    {

    }
}