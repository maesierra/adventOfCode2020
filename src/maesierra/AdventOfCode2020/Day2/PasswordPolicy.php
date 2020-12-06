<?php

namespace maesierra\AdventOfCode2020\Day2;

abstract class PasswordPolicy
{
    public $n1;
    public $n2;
    public $char;

    /**
     * PasswordPolicy constructor.
     * @param $n1
     * @param $n2
     * @param $char
     */
    public function __construct($n1, $n2, $char)
    {
        $this->n1 = $n1;
        $this->n2 = $n2;
        $this->char = $char;
    }

    /**
     * @param $password string
     * @return boolean true if the password matches the policy
     */
    public abstract function validate($password);
}