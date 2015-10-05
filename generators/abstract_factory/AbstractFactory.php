<?php 
//Example for abstract factory

interface IFactory
{
	public function createProduct(Product $product);
}

abstract class Factory implements IFactory
{
	protected $_name     = NULL;
	protected $_status   = 0;
	
	const STATUS_WORKING = 0;
	const STATUS_STOP 	 = 1;
	
	public function __construct($name = false)
	{
		if ($name) $this->_name = $name;
	}
	
	public function getFactoryName()
	{
		return $this->_name;
	}
	
	protected function getFactoryStatus()
	{
		return $this->_status;
	}
	
	protected function setFactoryStatus($status)
	{
		return $this->_status = $status;
	}
	
	public function getFactoryStatusLable()
	{
		return ($this->_status === self::STATUS_WORKING) ? 'working' : 'stopped';
	}
	
	public function stopFactory()
	{
		$this->setFactoryStatus(self::STATUS_STOP);
	}
	
	public function startFactory()
	{
		$this->setFactoryStatus(self::STATUS_START);
	}
	
	public function createProduct(Product $product)
	{
		if ($this->_status !== self::STATUS_WORKING) {
			echo 'Can\'t create product "' . $product->getProductName() . '":  Factory is already ' . $this->getFactoryStatusLable();
			return NULL;
		}
		echo 'Factory "' . $this->getFactoryName() . '": "' . $product->getProductName() . '" was Created <hr />';
		return $product;
	}
}

abstract class FactoryIT extends Factory
{
	abstract public function createSmartphone($name);
	abstract public function createLaptop($name);
	abstract public function createSoftware($name);
}