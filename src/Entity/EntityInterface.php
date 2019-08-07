<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 13:35
 */

namespace Switchforce1\MyEventSourcing\Entity;

use Switchforce1\MyEventSourcing\Command\CommandInterface;

/**
 * Class EntityInterface
 */
interface EntityInterface
{
    const MODE_UPDATE = 'UPDATE';
    const MODE_INSERT = 'INSERT';

    /**
     * @return array
     */
    public function getEventsData(): array;

    /**
     * @param string $mode
     * @return EntityInterface
     */
    public function setMode(string $mode);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * check if the given command is valid
     *
     * @param CommandInterface $command
     * @return bool
     */
    public function checkCommand(?CommandInterface $command = null): bool;

    /**
     * Generated Event Type
     *
     * @return string
     */
    public function getEventType();

    /**
     * Gets specific external (Not coming from command) options for the entity
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Sets specific external (Not coming from command) options for the entity
     *
     * @param array $options
     * @return mixed
     */
    public function setOptions(array $options);

    /**
     * Label of the options
     *
     * @return mixed
     */
    public function getEventLabel();
}