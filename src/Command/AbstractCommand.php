<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 17:00
 */

namespace Switchforce1\MyEventSourcing\Command;

use mysql_xdevapi\Exception;
use Psr\Http\Message\RequestInterface;

/**
 * Class AbstractCommand
 * @package Switchforce1\MyEventSourcing\Command
 */
class AbstractCommand implements CommandInterface
{
    /**
     * @var string
     */
    protected $mode;

    /**
     * @var mixed|RequestInterface
     */
    protected $systemRequest;

    /**
     * @var string
     */
    protected $functionalRequestId;

    /**
     * @var array
     */
    protected $oldData;

    /**
     * @var array
     */
    protected $requestData;

    /**
     * Real data to process
     *
     * @var array
     */
    protected $data;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var []
     */
    protected $userPermissions;

    /**
     * Permission to run this command
     *
     * @return array
     */
    public static function getPermissions(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return AbstractCommand
     */
    public function setMode(string $mode): AbstractCommand
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSystemRequest()
    {
        return $this->systemRequest;
    }

    /**
     * @param mixed $systemRequest
     * @return AbstractCommand
     */
    public function setSystemRequest($systemRequest)
    {
        $this->systemRequest = $systemRequest;
        return $this;
    }

    /**
     * @return string
     */
    public function getFunctionalRequestId(): ?string
    {
        return $this->functionalRequestId;
    }

    /**
     * @param string $functionalRequestId
     * @return AbstractCommand
     */
    public function setFunctionalRequestId(?string $functionalRequestId): AbstractCommand
    {
        $this->functionalRequestId = $functionalRequestId;
        return $this;
    }

    /**
     * @return array
     */
    public function getOldData(): array
    {
        return $this->oldData;
    }

    /**
     * @param array $oldData
     * @return AbstractCommand
     */
    public function setOldData(array $oldData): AbstractCommand
    {
        $this->oldData = $oldData;
        return $this;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * Sets RequestData and data
     *
     * @param array $requestData
     * @return AbstractCommand
     */
    public function setRequestData(array $requestData): AbstractCommand
    {
        $this->requestData = $requestData;
        $this->data = $requestData;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return AbstractCommand
     */
    public function setDate(\DateTime $date): AbstractCommand
    {
        $this->date = $date;
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
     * @return AbstractCommand
     */
    public function setUserId(string $userId): AbstractCommand
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserPermissions()
    {
        return $this->userPermissions;
    }

    /**
     * @param mixed $userPermissions
     * @return AbstractCommand
     */
    public function setUserPermissions($userPermissions)
    {
        $this->userPermissions = $userPermissions;
        return $this;
    }

    /**
     * @param AbstractCommand $originCommand
     * @param AbstractCommand $destinationCommand
     */
    public function copy(AbstractCommand $originCommand, AbstractCommand $destinationCommand)
    {
        $destinationCommand->setMode($originCommand->getMode());
        $destinationCommand->setSystemRequest($originCommand->getSystemRequest());
        $destinationCommand->setFunctionalRequestId($originCommand->getFunctionalRequestId());
        $destinationCommand->setOldData($originCommand->getOldData());
        $destinationCommand->setRequestData($originCommand->getRequestData());
        $destinationCommand->setDate($originCommand->getDate());
        $destinationCommand->setUserId($originCommand->getUserId());
        $destinationCommand->setUserPermissions($originCommand->getUserPermissions());
    }

    /**
     * Returns the real data to process by the command
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getRowId()
    {
       return 'UNDEFINED';
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'UNDEFINED';
    }

    /**
     * @return string
     */
    public function getOriginalEventId()
    {
        return 'UNDEFINED';
    }
}