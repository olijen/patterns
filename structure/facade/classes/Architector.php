<?php

class Architector extends Worker
{
    public function createUML($type)
    {
        $this->setTime(30);
    }
    
    public function createProjectModel($type)
    {
        $this->setTime(50);
    }

}