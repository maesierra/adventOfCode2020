<?php

namespace maesierra\AdventOfCode2020\Day4;

class Rule
{
    /** @var boolean */
    private $required;
    /** @var string regexp pattern */
    private $pattern;
    /** @var \Closure extra validation to be applied, it will take the regexp matches array */
    private $extraValidation;

    /**
     * Rule constructor.
     * @param bool $required
     * @param string $pattern
     * @param \Closure $extraValidation
     */
    public function __construct(bool $required, string $pattern = null, \Closure $extraValidation = null)
    {
        $this->required = $required;
        $this->pattern = $pattern;
        $this->extraValidation = $extraValidation;
    }


    public function apply($value)
    {
        if (!$this->required) {
            return true;
        }
        if (!preg_match($this->pattern, $value, $matches)) {
            return false;
        }
        $extraValidation = $this->extraValidation;
        if ($extraValidation) {
            return $extraValidation($value, $matches);
        } else {
            return true;
        }
    }
}