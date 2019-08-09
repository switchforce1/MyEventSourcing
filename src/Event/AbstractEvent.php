<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 08/08/19
 * Time: 15:04
 */

namespace Switchforce1\MyEventSourcing\Event;


abstract class AbstractEvent implements EventInterface
{
    /**
     *
     */

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $eventType;

    /**
     * @var string
     */
    protected $requiredId;

    /**
     * @var string
     */
    protected $applyDate;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $actionType;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $rowId;

    /**
     * @var string
     */
    protected $originEventId;

    /**
     * @var string
     */
    protected $userId;

    /**
     * AbstractEvent constructor.
     * @param string $label
     * @param string $eventType
     * @param string $requestId
     * @param string $applyDate
     * @param mixed $data
     * @param string $actionType
     * @param string $tableName
     * @param string $rowId
     * @param string $originEventId
     * @param string $userId
     */
    public function __construct(string $label,
                                string $eventType,
                                $requestId,
                                string $applyDate,
                                $data,
                                string $actionType,
                                string $tableName,
                                string $rowId,
                                string $originEventId,
                                string $userId)
    {
        $this->label = $label;
        $this->eventType = $eventType;
        $this->requiredId = $requestId;
        $this->applyDate = $applyDate;
        $this->data = $data;
        $this->actionType = $actionType;
        $this->tableName = $tableName;
        $this->rowId = $rowId;
        $this->originEventId = $originEventId;
        $this->userId = $userId;
    }


    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return AbstractEvent
     */
    public function setLabel(string $label): AbstractEvent
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     * @return AbstractEvent
     */
    public function setEventType(string $eventType): AbstractEvent
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequiredId(): string
    {
        return $this->requiredId;
    }

    /**
     * @param string $requiredId
     * @return AbstractEvent
     */
    public function setRequiredId(string $requiredId): AbstractEvent
    {
        $this->requiredId = $requiredId;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplyDate(): string
    {
        return $this->applyDate;
    }

    /**
     * @param string $applyDate
     * @return AbstractEvent
     */
    public function setApplyDate(string $applyDate): AbstractEvent
    {
        $this->applyDate = $applyDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return AbstractEvent
     */
    public function setData($data): AbstractEvent
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getActionType(): string
    {
        return $this->actionType;
    }

    /**
     * @param string $actionType
     * @return AbstractEvent
     */
    public function setActionType(string $actionType): AbstractEvent
    {
        $this->actionType = $actionType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     * @return AbstractEvent
     */
    public function setTableName(string $tableName): AbstractEvent
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return string
     */
    public function getRowId(): string
    {
        return $this->rowId;
    }

    /**
     * @param string $rowId
     * @return AbstractEvent
     */
    public function setRowId(string $rowId): AbstractEvent
    {
        $this->rowId = $rowId;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginEventId(): string
    {
        return $this->originEventId;
    }

    /**
     * @param string $originEventId
     * @return AbstractEvent
     */
    public function setOriginEventId(string $originEventId): AbstractEvent
    {
        $this->originEventId = $originEventId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return AbstractEvent
     */
    public function setUserId(string $userId): AbstractEvent
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $eventData = [
            "label" => $this->getLabel(),
            "event_type" => $this->getEventType(),
            "request_id" => $this->getRequiredId(),
            "apply_date" => $this->getApplyDate(),
            "data" => json_encode(["data" => $this->getData()]),
            "action_type" => $this->getActionType(),
            "table_name" => $this->getTableName(),
            "row_id" => $this->getRowId(),
            "origin_event_id" => $this->getOriginEventId(),
            "created_by" => $this->getUserId(),
        ];

        return [$eventData];
    }
}