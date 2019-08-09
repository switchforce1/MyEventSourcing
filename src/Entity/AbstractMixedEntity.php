<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 12:25
 */

namespace Switchforce1\MyEventSourcing\Entity;

use Switchforce1\MyEventSourcing\Command\CommandInterface;

/**
 * Class AbstractEntity
 * @package Switchforce1\MyEventSourcing\Entity
 */
abstract class AbstractMixedEntity extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    abstract protected function getConfig();

    /**
     * Set process data
     */
    protected function setData()
    {
        $this->data = $this->command->getData();
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


            if(array_key_exists('options', $config)){
                /** @var EntityInterface $entity */
                $entity  =  new $entityClassName($command, $config['options']);
            }else{
                /** @var EntityInterface $entity */
                $entity  =  new $entityClassName($command);
            }

            $entities [$node] = clone $entity;
            unset($entity);
        }

        return $entities;
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
                throw new \Exception(sprintf("The value is not an entity on node %s.", $node));
            }
            $data = array_merge($data, $entity->getEventsData());
        }

        return $data;
    }
}