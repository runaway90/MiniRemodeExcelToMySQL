<?php

namespace Controller\MicroserviceAPI;

class ModelAPI implements ModelAPIInterface
{
    private $name;

    private $name_concurrent;

    private $id_concurrent;

    private $ingrid;

    public function getIdConcurrent()
    {
        return $this->id_concurrent;
    }

    public function getNameConcurrent()
    {
        return $this->name_concurrent;
    }

    public function getIngrid()
    {
        return $this->ingrid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setIdConcurrent($concurrentId)
    {
        return $this->concurrentId=$concurrentId;
    }

    public function setName($name)
    {
        return $this->name=$name;
    }

    public function setNameConcurrent($concurrentName)
    {
        return $this->concurrentName=$concurrentName;
    }

    public function setIngrid($ingrid)
    {
        return $this->ingrid=$ingrid;
    }
}