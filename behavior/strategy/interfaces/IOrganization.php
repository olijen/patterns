<?php

interface IOrganization
{
    public function getOrganizationName();
    
    public function getTax();
    
    public function getInfo();
    
    public function getCapital();
    
    public function setIncome($income);
}
