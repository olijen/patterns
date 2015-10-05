<?php
interface IProduct
{
	public function getProductName();
}

abstract class Product implements IProduct
{
	protected $_name = NULL;
	
	public function __construct($name)
	{
		$this->_name = $name;
	}
	
	public function getProductName()
	{
		return $this->_name;
	}
}

// Products

abstract class ProductIT extends Product
{
	
}
