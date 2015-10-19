<?php

//Facade - use some developers for create project

class Company
{
    protected $_designer;
    protected $_frontend;
    protected $_backend;
    protected $_DBA;
    protected $_architector;
    
    protected $_name;
    
    public function __construct(
        $name,
        Designer    $designer,
        Frontend    $frontend,
        Backend     $backend,
        DBA         $dba,
        Architector $architector)
    {
        $this->_designer    = $designer;
        $this->_frontend    = $frontend;
        $this->_backend     = $backend;
        $this->_DBA         = $dba;
        $this->_architector = $architector;
        
        $this->_name = $name;
    }
    
    public function createSite($name)
    {
        $this->_designer->createDesign('site');
        $this->_frontend->createFrontend('site');
    }
    
    public function createECommerce($name)
    {
        $this->_designer->createDesign('EC_system');
        $this->_frontend->createFrontend('EC_system');
        $this->_backend->createBackend('EC_system');
        $this->_backend->createSimpleDatabase('EC_system');
    }
    
    public function createCRMSystem($name)
    {
        $this->_architector->createUML('CRM');
        $this->_architector->createProjectModel('CRM');
        $this->_DBA->createDBModel('CRM');
        $this->_designer->createUI('CRM');
        $this->_designer->createDesign('CRM');
        $this->_frontend->createFrontend('CRM');
        $this->_backend->createBackend('CRM');
    }
    
    public function getWorker($worker)
    {
        return $this->{'_' . $worker}; //TODO: add black list!
    }
}