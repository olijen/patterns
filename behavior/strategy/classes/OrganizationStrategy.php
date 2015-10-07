<?php

abstract class OrganizationStrategy implements IOrganizationStrategy
{
    protected $_tax;
    protected $_type;
    
    public function getTax()
    {
        return $this->_tax;
    }
    
    public function getType()
    {
        return $this->_type;
    }
}