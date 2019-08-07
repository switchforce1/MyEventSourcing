<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 13:17
 */

namespace Switchforce1\MyEventSourcing\Entity;
use Switchforce1\MyEventSourcing\Command\CommandInterface;

/**
 * Class AnimalNameEntity
 * @package Switchforce1\MyEventSourcing\Entity
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
            "label" => "Modification de l'espece",
            "event_type" => $this->getEventType(),
            "request_id" => $this->command->getFunctionalRequestId(),
            "apply_date" => $today,
            "data" => json_encode(["data" => $this->getData()]),
            "action_type" => $this->command->getSystemRequest()->getMethod(),
            "table_name" => "animal",
            "row_id" => $options['row_id']?? null,
            "origin_event_id" => $options['row_id']?? null,
            "created_by" => $this->command->getUserId(),
        ];

        $data[] = $eventData;
        return $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        // TODO: Implement getData() method.
    }

    /**
     * check if the given command is valid
     *
     * @param CommandInterface $command
     * @return bool
     */
    public function checkCommand(CommandInterface $command = null): bool
    {

    }

    /**
     * @return string
     */
    public function getEventType()
    {
        // TODO: Implement getEventType() method.
    }

    /**
     * @return mixed
     */
    public function getEventLabel()
    {
        // TODO: Implement getEventLabel() method.
    }
}