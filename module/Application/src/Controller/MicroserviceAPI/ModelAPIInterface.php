<?php

namespace Controller\MicroserviceAPI;

interface ModelAPIInterface
{
    public function getName();

    public function getNameConcurrent();

    public function getIngrid();

    public function getIdConcurrent();

    public function setName($name);

    public function setNameConcurrent($concurrentName);

    public function setIngrid($ingrid);

    public function setIdConcurrent($concurrentId);

}
