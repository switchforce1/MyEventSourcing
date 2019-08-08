<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 13:17
 */

namespace Switchforce1\MyEventSourcing\Entity;
use Switchforce1\MyEventSourcing\Command\AnimalCommand;
use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Command\HolderCommand;

/**
 * Class AnimalNameEntity
 * @package Switchforce1\MyEventSourcing\Entity
 */
class AnimalHolderAgeEntity extends AbstractEntity implements EntityInterface
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
            "label" => $this->getEventLabel(),
            "event_type" => $this->getEventType(),
            "request_id" => $this->command->getFunctionalRequestId(),
            "apply_date" => $today,
            "data" => json_encode(["data" => $this->getData()]),
            "action_type" => $this->command->getSystemRequest()? $this->command->getSystemRequest()->getMethod(): $this->command->getMode(),
            "table_name" => "contact",
            "row_id" => $options['row_id']?? null,
            "origin_event_id" => $options['origin_event_id']?? null,
            "created_by" => $this->command->getUserId(),
        ];

        $data[] = $eventData;
        return $data;
    }

    /**
     *
     */
    protected function setData()
    {
        /** @var HolderCommand $command */
       $command = $this->command;
       $data = $command->getData()['age'];
       $this->data = $data;
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
        return $command instanceof HolderCommand;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return 'animal.assign.holder.age';
    }

    /**
     * @return mixed
     */
    public function getEventLabel()
    {
        return 'Modification de l\'age du détenteur .';
    }
}