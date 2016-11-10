<?php
use Example\Strength;
use Example\Elf;

require_once __DIR__ . '/Example/Strength.php';
require_once __DIR__ . '/Example/Elf.php';

$strength = new Strength();
$strength->addStrengthFromRace(new Elf());
$strength->addBonusFromHeight(15);
$strength->addMalusFromFatigue(7);

echo implode(' ', $strength->getChanges()) . PHP_EOL;