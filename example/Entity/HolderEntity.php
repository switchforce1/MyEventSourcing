<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 13:34
 */

namespace Switchforce1\MyEventSourcing\Example\Entity;

use Switchforce1\MyEventSourcing\Entity\CommonScalarEntity;
use Switchforce1\MyEventSourcing\Example\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Example\Command\HolderCommand;
use Switchforce1\MyEventSourcing\Entity\AbstractMixedEntity;
use Switchforce1\MyEventSourcing\Event\CommonScalarEvent;
use Switchforce1\MyEventSourcing\Entity\AbstractEntity;
use Switchforce1\MyEventSourcing\Entity\EntityInterface;

class HolderEntity extends AbstractMixedEntity
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
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
            return 'animal.insert';
        }

        return 'animal.update';
    }

    /**
     * Label of the options
     *
     * @return mixed
     */
    public function getEventLabel()
    {
        if($this->mode = self::MODE_INSERT){
            return 'Creation d\'un détenteur ';
        }

        return 'Modification d\'un détenteur ';
    }

    /**
     * @inheritdoc
     */
    protected function getConfig()
    {
        /** @var HolderCommand $command */
        $command = $this->command;

        return [
            'name' => [
                'class' => AnimalHolderNameEntity::class,
                'command' => $command,
            ],
            'age' => [
                'class' => AnimalHolderAgeEntity::class,
                'command' => $command,
            ],
            "tel" => [
                'class' => CommonScalarEntity::class,
                'command' => $this->command,
                'options' => [
                    "field_name" => "tel",
                    "event_class" => CommonScalarEvent::class,
                    "command_class" => HolderCommand::class,
                    "table_name" => "contact",
                    "row_id" => $this->command->getRowId(),
                    "event_type" => function(){
                        return "animal.tel.update";
                    },
                    "event_label" => function(){
                        return "Modification du telephone du proprietaire";
                    },
                ]
            ],
        ];
    }
}