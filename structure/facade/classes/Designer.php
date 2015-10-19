<?php

class Designer extends Worker
{
    public function createDesign($type)
    {
        $this->setTime(13);
    }
    
    public function createUI($type)
    {
        $this->setTime(19);
    }
}