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
abstract class AbstractEntity implements EntityInterface
{
    /**
     * Defines the way the event will be generated
     * Defaults are insert and Update
     * @var string
     */
    protected $mode;

    /**
     * @var CommandInterface
     */
    protected $command;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * Additional options when needed
     * @var array
     */
    protected $options = [];

    /**
     * AbstractEntity constructor.
     *
     * @param CommandInterface $command
     * @throws \Exception
     */
    public function __construct(CommandInterface $command)
    {
        // check if the command  is allowed
        if (!$this->checkCommand($command)){
            throw new \Exception(sprintf("The given command (%s) is not allowed for this entity (%s)",
                get_class($command),
                get_class($this))
            );
        }
        $this->command = $command;
        $this->setMode($command->getMode());
    }

    /**
     * The mode of the entity
     *
     * @param $mode
     * @return $this
     */
     public function setMode(string $mode)
     {
        $this->mode = $mode;
         return $this;
     }

    /**
     * @inheritdoc
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return AbstractEntity
     */
    public function setOptions(array $options): AbstractEntity
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPermissions(): array
    {
        return [];
    }

    /**
     * @param array $requestPermissions
     * @return bool|mixed
     */
    public function checkPermissions($requestPermissions = [])
    {
        if(empty($this->getPermissions())
            || in_array('all', $requestPermissions)
            || (empty($this->getPermissions()) && empty($requestPermissions))){
            return true;
        }
        return !empty(array_intersect($requestPermissions, $this->getPermissions()));
    }
}