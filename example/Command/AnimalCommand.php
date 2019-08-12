<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 15:35
 */

namespace Switchforce1\MyEventSourcing\Example\Command;

use Switchforce1\MyEventSourcing\Command\AbstractCommand;
use Switchforce1\MyEventSourcing\Command\CommandInterface;

/**
 * Class AnimalCommand
 * @package Switchforce1\MyEventSourcing\Command
 */
class AnimalCommand extends AbstractCommand implements CommandInterface
{
    public function getRowId()
    {
        return parent::getRowId();
    }
}