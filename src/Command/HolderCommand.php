<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 15:35
 */

namespace Switchforce1\MyEventSourcing\Command;

/**
 * Class AnimalCommand
 * @package Switchforce1\MyEventSourcing\Command
 */
class HolderCommand extends AbstractCommand implements CommandInterface
{
    /**
     * HolderCommand constructor.
     * @param AnimalCommand $command
     */
    public function __construct(AnimalCommand $command)
    {
        parent::copy($command, $this);
        $this->data = $command->getData()['holder'];
    }

}