<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 08/08/19
 * Time: 16:25
 */

namespace Switchforce1\MyEventSourcing\Event;

use Switchforce1\MyEventSourcing\Entity\AbstractScalarEntity;

/**
 * Class CommonScalarEvent
 * @package Switchforce1\MyEventSourcing\Event
 */
class CommonScalarEvent extends AbstractEvent
{


    // parent::__construct($label, $eventType, $requiredId, $applyDate, $data, $actionType, $tableName, $rowId, $originEventId, $userId);
    /**
     * CommonScalarEvent constructor.
     */
    public function __construct(AbstractScalarEntity $entity)
    {
        parent::__construct(
            $entity->getEventLabel(),
            $entity->getEventType(),
            $entity->getRequestId()?? '',
            $entity->getApplyDate()->format("Y-m-d H:i:s"),
            $entity->getData(),
            $entity->getMode(),
            $entity->getOptions()['table_name'] ?? 'UNDEFINED',
            $entity->getOptions()['row_id']?? 'UNDEFINED',
            $entity->getOptions()['origin_event_id']?? 'UNDEFINED',
            $entity->getUserId()
        );
    }
}