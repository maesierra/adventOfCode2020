<?php

namespace maesierra\AdventOfCode2020\Day2;

class Policy1 extends PasswordPolicy
{

    public function validate($password)
    {
        $count = substr_count($password, $this->char);
        return $count >= $this->n1 && $count <= $this->n2;
    }
}