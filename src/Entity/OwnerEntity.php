<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 13:34
 */

namespace Switchforce1\MyEventSourcing\Entity;

use Switchforce1\MyEventSourcing\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Command\HolderCommand;

class OwnerEntity extends AbstractMixedEntity
{
    /**
     * HolderEntity constructor.
     * @param HolderCommand $holderCommand
     */
    public function __construct(HolderCommand $holderCommand)
    {
        $this->command = $holderCommand;
    }

    /**
     * Check if the given command is valid
     *
     * @param CommandInterface $command
     * @return bool
     */
    public function checkCommand(?CommandInterface $command = null): bool
    {
        // if null use $this->command
        if(!$command){
            $command = $this->command;
        }
        return $command instanceof HolderCommand;
    }

    /**
     * Generated Event Type
     *
     * @return string
     */
    public function getEventType()
    {
        if($this->mode = self::MODE_INSERT){
            return 'owner.insert';
        }

        return 'owner.update';
    }

    /**
     * Label of the options
     *
     * @return mixed
     */
    public function getEventLabel()
    {
        if($this->mode = self::MODE_INSERT){
            return 'Creation d\'un proprietaire.';
        }

        return 'Modification d\'un proprietaire.';
    }

    /**
     * @inheritdoc
     */
    protected function getConfig()
    {
        return [];
    }
}