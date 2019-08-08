<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 12:25
 */

namespace Switchforce1\MyEventSourcing\Entity;

use Switchforce1\MyEventSourcing\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Command\HolderCommand;

/**
 * Class AnimalEntity
 * @package Switchforce1\MyEventSourcing\Entity
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
            'holder' => [
                'class' => HolderEntity::class,
                'command' => new HolderCommand($command),
            ],
            'owner' => [
                'class' => OwnerEntity::class,
                'command' => new HolderCommand($command),
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