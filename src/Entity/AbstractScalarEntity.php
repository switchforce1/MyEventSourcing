<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 12:25
 */

namespace Switchforce1\MyEventSourcing\Entity;

use Switchforce1\MyEventSourcing\Command\CommandInterface;
use Switchforce1\MyEventSourcing\Event\CommonScalarEvent;
use Switchforce1\MyEventSourcing\Event\EventInterface;

/**
 * Class AbstractEntity
 * @package Switchforce1\MyEventSourcing\Entity
 */
abstract class AbstractScalarEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * AbstractScalarEntity constructor.
     *
     * @param CommandInterface $command
     * @param array $options
     * @throws \Exception
     */
    public function __construct(CommandInterface $command, array $options = [])
    {
        if(!empty($this->checkOptions($options))){
            throw new \Exception('Bad Options given for the current entity.');
        }
        $this->options = $options;
        parent::__construct($command);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function checkOptions(array $options)
    {
        $errors = [];
        // Field name
        if(!array_key_exists('field_name', $options)){
            $errors[] = sprintf("[%s] not found in the options of %s class",
                'field_name',
                get_class($this)
            );
        }
        //check event class
        if(!array_key_exists('event_class', $options) ||
            !class_exists($options['event_class'])){
            $errors[] = sprintf("[%s] not found in the options of %s class",
                'event_class',
                get_class($this)
            );
        }
        //allow Command class
        if(!array_key_exists('command_class', $options) ||
            !class_exists($options['command_class'])){
            $errors[] = sprintf("[%s] not found in the options of %s class",
                'command_class',
                get_class($this)
            );
        }
        //allow Command class
        if(!array_key_exists('event_type', $options)){
            $errors[] = sprintf("[%s] not found in the options of %s class",
                'event_type',
                get_class($this)
            );
        }
        //allow Command class
        if(!array_key_exists('event_label', $options)){
            $errors[] = sprintf("[%s] not found in the options of %s class",
                'event_label',
                get_class($this)
            );
        }


        return $errors;
    }

    /**
     *
     */
    protected function setData()
    {
        $this->data = $this->command->getData()[$this->options['field_name']];
    }

    /**
     * @return array
     */
    public function getEventsData(): array
    {
        $eventClassName = $this->options['event_class'];
        /** @var CommonScalarEvent $scalarEvent */
        $scalarEvent = new $eventClassName($this);

        return $scalarEvent->toArray();
    }

    /**
     * check if the given command is valid
     *
     * @param CommandInterface $command
     * @return bool
     */
    public function checkCommand(?CommandInterface $command = null): bool
    {
        $commandClass = $this->options['command_class'];
        // if null use $this->command
        if(!$command){
            $command = $this->command;
        }
        return (get_class($command) == $commandClass);
    }

    /**
     * Generated Event Type
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function getEventType()
    {
        // callable
        if (is_callable($this->options['event_type'])){
            $callable = $this->options['event_type'];
            return $callable($this);
        }
        // string
        if(is_string($this->options['event_type'])){
            return $this->options['event_type'];
        }

        return sprintf("animal.%s.%s", $this->options['field_name'], strtolower($this->getMode()));
    }

    /**
     * Label of the options
     *
     * @return mixed
     * @throws \Exception
     */
    public function getEventLabel()
    {
        // callable
        if (is_callable($this->options['event_label'])){
            $callable = $this->options['event_label'];
            return $callable();
        }
        // string
        if(is_string($this->options['event_label'])){
            return $this->options['event_label'];
        }

        throw new \Exception("The event label can't be processed");
    }
}