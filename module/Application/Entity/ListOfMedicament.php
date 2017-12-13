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
     * @ORM\Column(name="name")
     */
    protected $name;

    // Возвращает ID данного тега.
    public function getId()
    {
        return $this->id;
    }

    // Задает ID данного тега.
    public function setId($id)
    {
        $this->id = $id;
    }

    // Возвращает имя.
    public function getName()
    {
        return $this->name;
    }

    // Задает имя.
    public function setName($name)
    {
        $this->name = $name;
    }
}
