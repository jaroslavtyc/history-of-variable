<?php
namespace Example;

require_once __DIR__ . '/Race.php';

class Elf extends Race
{
    /**
     * @return int
     */
    public function getStrength()
    {
        return -1;
    }

}