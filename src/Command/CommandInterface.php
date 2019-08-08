<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 06/08/19
 * Time: 15:36
 */

namespace Switchforce1\MyEventSourcing\Command;

/**
 * Class CommandInterface
 * @package Switchforce1\MyEventSourcing\Command
 */
interface CommandInterface
{
    /**
     * @return string
     */
    public function getMode(): string;

    /**
     * Permission to run this command
     *   Is static and may be defined in all classes that implements this interface
     *
     * @return array
     */
    public static function getPermissions(): array;

    /**
     * Returns  System request -> Http request
     *
     * @return mixed|
     */
    public function getSystemRequest();

    /**
     * Function request ID (App request id = demande)
     *
     * @return string
     */
    public function getFunctionalRequestId(): ?string;

    /**
     * Returns old data in update case
     *
     * @return array
     */
    public function getOldData(): array;

    /**
     * Returns Request data
     *
     * @return array
     */
    public function getRequestData(): array;

    /**
     * Returns the real data to process by the command
     *
     * @return array
     */
    public function getData();

    /**
     * Returns current date
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime;

    /**
     * current user id
     *
     * @return string
     */
    public function getUserId(): string;

    /**
     * Permissions of the user running this command
     *
     * @return mixed
     */
    public function getUserPermissions();
}