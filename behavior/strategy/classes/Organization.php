<?php

class Organization implements IOrganization
{
    protected $_name;
    protected $_strategy;
    protected $_capital = 0;
    
    public function __construct($name, OrganizationStrategy $strategy)
    {
        $this->_name     = $name;
        $this->_strategy = $strategy;
    }
    
    public function setIncome($income)
    {
        echo '<hr> '. $this->getOrganizationName() .' Income: $' . $income;
        $income -= ($income / 100 * $this->getTax());
        $this->_capital += $income;
        return $this;
    }
    
    public function getOrganizationName()
    {
        return $this->_name;
    }
    
    public function getTax()
    {
        return $this->_strategy->getTax();
    }
    
    public function getCapital()
    {
        return $this->_capital;
    }
    
    public function getInfo()
    {
        echo '<br><br><hr> Organization name: ' . $this->getOrganizationName();
        echo '<hr> Organization type: '         . $this->_strategy->getType();
        echo '<hr> Organization tax: '          . $this->getTax();
        echo '<hr> Organization capital: $'     . $this->getCapital();
        echo '<hr>';
        return $this;
    }
}
