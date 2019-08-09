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
use Switchforce1\MyEventSourcing\Command\OwnerCommand;
use Switchforce1\MyEventSourcing\Event\AbstractEvent;
use Switchforce1\MyEventSourcing\Event\CommonScalarEvent;
use Switchforce1\MyEventSourcing\Event\EventInterface;

class OwnerEntity extends AbstractMixedEntity
{
    /**
     * HolderEntity constructor.
     * @param HolderCommand $holderCommand
     */
    public function __construct(OwnerCommand $ownerCommand)
    {
        $this->command = $ownerCommand;
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
        return $command instanceof OwnerCommand;
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
        return [
            "name" => [
                'class' => CommonScalarEntity::class,
                'command' => $this->command,
                'options' => [
                    "field_name" => "name",
                    "event_class" => CommonScalarEvent::class,
                    "command_class" => OwnerCommand::class,
                    "table_name" => "contact",
                    "row_id" => $this->command->getRowId(),
                    "event_type" => function(){
                        return "animal.name.update";
                    },
                    "event_label" => function(){
                        return "Modification du nom du proprietaire";
                    },
                ]
            ]
        ];
    }
}