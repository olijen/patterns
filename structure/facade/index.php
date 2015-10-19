<?php

require '../../_services/base.php';
load([
    'classes/Company',
    
	'classes/Worker',
    'classes/Designer',
    'classes/Backend',
    'classes/Frontend',
    'classes/DBA',
    'classes/Architector',
]);

$company = new Company('SITIO',
    new Designer('Ira', 10),
    new Frontend('Oleg', 20),
    new Backend('Andrey', 20),
    new DBA('Anton', 25),
    new Architector('Alina', 40)
);

$company->createSite('Simple site');
$company->createCRMSystem('SITIO CRM');

echo $company->getWorker('designer')->getPrice();