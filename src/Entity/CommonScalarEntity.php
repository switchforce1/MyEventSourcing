<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 12:25
 */

namespace Switchforce1\MyEventSourcing\Entity;

use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Event\CommonScalarEvent;
use Switchforce1\MyEventSourcing\Event\EventInterface;

/**
 * Class AbstractEntity
 * @package Switchforce1\MyEventSourcing\Entity
 */
class CommonScalarEntity extends AbstractScalarEntity implements EntityInterface
{

}