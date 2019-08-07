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

/**
 * Class AnimalEntity
 * @package Switchforce1\MyEventSourcing\Entity
 */
class AnimalEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var CommandInterface
     */
    protected $command ;

    /**
     * AnimalEntity constructor.
     * @param CommandInterface $command
     */
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    /**
     *
     */
    protected function init()
    {
        $configs = $this->getConfig();
    }


    /**
     * @param CommandInterface $command
     */
    protected function setCommand(CommandInterface $command)
    {
        $this->command = $command;
    }

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
        return [
            'name' => [
                'class' => AnimalNameEntity::class,
                'command' => $this->command,
            ],
            'holder' => [
                HolderEntity::class,
                'command' => $this->command,
            ]
        ];
    }

    /**
     * Returns array of events data that will be insert into database
     *
     * @return array
     * @throws \Exception
     */
    public function getEventsData():array
    {
        $data = [];

        /**
         * @var string $node
         * @var EntityInterface $entity
         */
        foreach ($this->getEntities() as $node => $entity){
            if(!$entity instanceof EntityInterface){
                throw new \Exception("");
            }
            $data = array_merge($data, $entity->getEventsData());
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    protected function getEntities(): array
    {
        $entities = [];
        foreach ($this->getConfig() as $node => $config){
            /** @var string $entityClassName */
            $entityClassName = $config['class'];
            /** @var CommandInterface $command */
            $command = $config['command'];

            /** @var EntityInterface $entity */
            $entity  =  new $entityClassName($command);

            $entities [$node] = clone $entity;
            unset($entity);
        }

        return $entities;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->command->getRequestData();
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