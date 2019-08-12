<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 12:25
 */

namespace Switchforce1\MyEventSourcing\Example\Entity;

use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Entity\AbstractEntity;
use Switchforce1\MyEventSourcing\Entity\AbstractMixedEntity;
use Switchforce1\MyEventSourcing\Entity\CommonScalarEntity;
use Switchforce1\MyEventSourcing\Entity\EntityInterface;
use Switchforce1\MyEventSourcing\Event\CommonScalarEvent;
use Switchforce1\MyEventSourcing\Example\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Example\Command\HolderCommand;
use Switchforce1\MyEventSourcing\Example\Command\OwnerCommand;

/**
 * Class AnimalEntity
 * @package Switchforce1\MyEventSourcing\Example\Entity
 */
class AnimalEntity extends AbstractMixedEntity implements EntityInterface
{

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return [];
    }

    /**
     * Entity static configuration
     *
     * @param string $mode
     * @param array $permissions
     * @return array
     */
    protected function getConfig()
    {
        /** @var AnimalCommand $command */
        $command = $this->command;

        return [
            'name' => [
                'class' => AnimalNameEntity::class,
                'command' => $command,
            ],
            "birth_date" => [
                'class' => CommonScalarEntity::class,
                'command' => $this->command,
                'options' => [
                    "field_name" => "birth_date",
                    "event_class" => CommonScalarEvent::class,
                    "command_class" => AnimalCommand::class,
                    "table_name" => "animal",
                    "row_id" => $this->command->getRowId(),
                    "event_type" => function(){
                        return "animal.birth_date.update";
                    },
                    "event_label" => function(){
                        return "Modification du birth_date du proprietaire";
                    },
                ]
            ],
            "death_date" => [
                'class' => CommonScalarEntity::class,
                'command' => $this->command,
                'options' => [
                    "field_name" => "death_date",
                    "event_class" => CommonScalarEvent::class,
                    "command_class" => AnimalCommand::class,
                    "table_name" => "animal",
                    "row_id" => $this->command->getRowId(),
                    "event_type" => function(){
                        return "animal.death_date.update";
                    },
                    "event_label" => function(){
                        return "Modification du death_date du proprietaire";
                    },
                ]
            ],
            'holder' => [
                'class' => HolderEntity::class,
                'command' => new HolderCommand($command),
            ],
            'owner' => [
                'class' => OwnerEntity::class,
                'command' => new OwnerCommand($command),
            ]
        ];
    }

    /**
     * check if the given command is valid
     *
     * @param CommandInterface $command [if null run with $this->command]
     * @return bool
     */
    public function checkCommand(?CommandInterface $command = null): bool
    {
        // if null use $this->command
        if(!$command){
            $command = $this->command;
        }
        return $command instanceof AnimalCommand;
    }

    /**
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
     * @return mixed
     */
    public function getEventLabel()
    {
        if($this->mode = self::MODE_INSERT){
            return 'Creation d\'un animal ';
        }

        return 'Modification d\'un animal';
    }
}