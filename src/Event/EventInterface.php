<?php
/**
 * Created by PhpStorm.
 * User: prest.dadja
 * Date: 08/08/19
 * Time: 15:04
 */

namespace Switchforce1\MyEventSourcing\Event;


interface EventInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}