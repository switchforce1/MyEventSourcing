<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 07/08/19
 * Time: 14:50
 */
require 'vendor/autoload.php';

use Switchforce1\MyEventSourcing\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Entity\AbstractEntity;
use Switchforce1\MyEventSourcing\Entity\AnimalEntity;

echo "RUN - With tess data".PHP_EOL;

$animalData = [
    "name" => "DOG",
    "holder" => [
        "name" => "the holder name",
        "age" => 121,
        "tel" => "45 88 78 45 45",
    ],
    "owner" => [
        "name" => "the owner name",
        "age" => 88,
        "tel" => "0000000000000",
    ]
];
/** @var AnimalCommand $animalCommand */
$animalCommand = new AnimalCommand();
$animalCommand
    ->setUserPermissions([])
    ->setMode(AbstractEntity::MODE_INSERT)
    ->setOldData([])
    ->setRequestData($animalData)
    ->setDate(new \DateTime())
    ->setUserId('user Uuid')
;

$animalEntity = new AnimalEntity($animalCommand);

$eventData = $animalEntity->getEventsData();
print_r("**** ** ".PHP_EOL);

print_r($eventData);

print_r("**** ** ".PHP_EOL);

echo "END RUN a".PHP_EOL;
