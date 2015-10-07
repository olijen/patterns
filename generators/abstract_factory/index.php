<?php

require '../../_services/base.php';
load([
	'AbstractFactory',
	'ConcreteFactorys',
	'AbstractProducts',
	'ConcreteProducts,
']);

	$googleFactory = new Google;
	$googleFactory->createSmartphone('Android');
	$googleFactory->createSoftware('Angular');
	
	$appleFactory = new Apple;
	$appleFactory->createSmartphone('Macintosh');
	$appleFactory->createSoftware('Swift');
	
	$appleFactory->stopFactory();
	
	$appleFactory->createSoftware('Swift');