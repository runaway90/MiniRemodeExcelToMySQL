<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="list_of_medicament")
 */
class ListOfMedicament
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="id_concurrent")
     */
    protected $id_concurrent;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIdConcurrent()
    {
        return $this->id_concurrent;
    }

    public function setIdConcurrent($id_concurrent)
    {
        $this->id_concurrent = $id_concurrent;
    }

}
