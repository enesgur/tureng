<?php
namespace enesgur;


interface TurengInterface
{
    /**
     * @param array|string $world
     * @return object
     */
    public function word($world = array());

    /**
     * @return array
     */
    public function translate();

    /**
     * @return object
     */
    public function clear();
}