<?php

abstract class Worker
{
    protected $_name;
    protected $_time;
    protected $_price;
    
    public function __construct($name, $price)
    {
        $this->_time  = $time;
        $this->_price = $price;
    }
    
    public function getPrice()
    {
        return $this->_price * $this->_time;
    }
    
    public function getTime()
    {
        return $this->_time;
    }
    
    public function getName()
    {
        return $this->_name;
    }
    
    public function setTime($time)
    {
        if ((int)$time > 0)
            $this->_time = $this->_time + $time;
        return $this;
    }
}