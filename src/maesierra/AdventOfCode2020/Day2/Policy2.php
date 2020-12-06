<?php

namespace maesierra\AdventOfCode2020\Day2;

class Policy2 extends PasswordPolicy
{

    public function validate($password)
    {
        $password = str_split($password);
        $char1 = $password[$this->n1 - 1] ?? '';
        $char2 = $password[$this->n2 - 1] ?? '';
        return ($char1 == $this->char && $char2 != $this->char) || ($char2 == $this->char && $char1 != $this->char);
    }
}