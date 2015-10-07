<?php

require '../../_services/base.php';
load([
    'interfaces/IOrganization',
    'interfaces/IOrganizationStrategy',
	'classes/OrganizationStrategy',
    'classes/Organization',
    'classes/OOOStrategy',
    'classes/LLCStrategy',
]);

$kSoftwere = new Organization('SITIO',     new OOOStrategy);
$oSoftwere = new Organization('Montifik',  new LLCStrategy);

$kSoftwere->getInfo()
    ->setIncome(10000)
    ->getInfo();
    
$oSoftwere->getInfo()
    ->setIncome(10000)
    ->getInfo();