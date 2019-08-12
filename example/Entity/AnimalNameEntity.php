<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 13:17
 */

namespace Switchforce1\MyEventSourcing\Example\Entity;

use Switchforce1\MyEventSourcing\Example\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Entity\AbstractEntity;
use Switchforce1\MyEventSourcing\Entity\EntityInterface;

/**
 * Class AnimalNameEntity
 * @package Switchforce1\MyEventSourcing\Example\Entity
 */
class AnimalNameEntity extends AbstractEntity implements EntityInterface
{

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return [];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getEventsData(): array
    {
        $today = (new \DateTime('now'))->format("Y-m-d H:i:s");
        $options = $this->getOptions();
        $data = [];
        $eventData = [
            "label" => "Modification du nom de l'animal.",
            "event_type" => $this->getEventType(),
            "request_id" => $this->command->getFunctionalRequestId(),
            "apply_date" => $today,
            "data" => json_encode(["data" => $this->getData()]),
            "action_type" => $this->command->getSystemRequest()? $this->command->getSystemRequest()->getMethod(): $this->command->getMode(),
            "table_name" => "animal",
            "row_id" => $options['row_id']?? null,
            "origin_event_id" => $options['row_id']?? null,
            "created_by" => $this->command->getUserId(),
        ];

        $data[] = $eventData;
        return $data;
    }

    /**
     * check if the given command is valid
     *
     * @param CommandInterface $command
     * @return bool
     */
    public function checkCommand(CommandInterface $command = null): bool
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
            return 'animal.init.name';
        }

        return 'animal.update.name';
    }

    /**
     * @return mixed
     */
    public function getEventLabel()
    {
        if($this->mode = self::MODE_INSERT){
            return 'Assignation du nom';
        }

        return 'Modification du nom de l\' animal';
    }

    /**
     * Set name data
     */
    protected function setData()
    {
        $this->data = $this->command->getData()['name'];
    }
}