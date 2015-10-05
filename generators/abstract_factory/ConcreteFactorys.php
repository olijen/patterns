<?php

//Concrete factory

class Apple extends FactoryIT
{
	protected $_name = 'Apple';
	
	public function createSmartphone($name)
	{
		return $this->createProduct(new Smartphone($name));
	}
	
	public function createLaptop($name)
	{
		return $this->createProduct(new Laptop($name));
	}
	
	public function createSoftware($name)
	{
		return $this->createProduct(new Software($name));
	}
}

class Google extends FactoryIT
{
	protected $_name = 'Google';
	
	public function createSmartphone($name)
	{
		return $this->createProduct(new Smartphone($name));
	}
	
	public function createLaptop($name)
	{
		return $this->createProduct(new Laptop($name));
	}
	
	public function createSoftware($name)
	{
		return $this->createProduct(new Software($name));
	}
}