<?php

namespace Application\Entity;

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
}