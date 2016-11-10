<?php

namespace Example;

class Strength
{

    private $value = 0;
    private $previousValue;
    private $changes = [];

    public function __construct()
    {
        $this->changes[] = $this->value;
        $this->previousValue = $this->value;
    }

    public function addStrengthFromRace(Race $race)
    {
        $this->value += $race->getStrength();
        $this->noticeChange();
    }

    private function noticeChange()
    {
        $backtrace = debug_backtrace();
        $changingCall = $backtrace[1]; // penultimate step (that before calling noticeChange)
        $this->changes[] = ($this->value - $this->previousValue) . ' (' . $this->extractChangesFromBacktrace($changingCall) . ')';
        $this->changes[] = '= ' . $this->value;
        $this->previousValue = $this->value;
    }

    private function extractChangesFromBacktrace(array $backtrace)
    {
        $action = $this->formatToSentence($backtrace['function']);
        $argumentsDescription = $this->extractArgumentsDescription($backtrace['args']);

        return "$action($argumentsDescription)";
    }

    /**
     * @param string $string
     * @return string
     */
    private function formatToSentence($string)
    {
        preg_match_all('~(^|[A-Z])[a-z]+~', $string, $matches);

        return implode(
            ' ',
            array_map(
                function ($name) {
                    return lcfirst($name);
                },
                $matches[0]
            )
        );
    }

    /**
     * @param array $arguments
     * @return string
     */
    private function extractArgumentsDescription(array $arguments)
    {
        $descriptions = [];
        foreach ($arguments as $argument) {
            if (is_scalar($argument)) {
                $descriptions[] = var_export($argument, true);
            } elseif (is_object($argument)) {
                $descriptions[] = get_class($argument);
            } else {
                $descriptions[] = gettype($argument);
            }
        }

        return implode(',', $descriptions);
    }

    public function addBonusFromHeight($height)
    {
        $this->value += (int)round($height / 5);
        $this->noticeChange();
    }

    public function addMalusFromFatigue($fatigue)
    {
        $this->value += $fatigue < 2
            ? 0
            : -1;
        $this->noticeChange();
    }

    public function getChanges()
    {
        return array_map(
            function ($change) {
                $change = preg_replace('~\(add ~', '(', $change);
                $change = preg_replace('~^(\d)~', '+ $1', $change);
                $change = preg_replace('~^-(\d)~', '- $1', $change);
                return $change;
            },
            $this->changes
        );
    }
}