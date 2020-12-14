<?php


namespace maesierra\AdventOfCode2020\Day14;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Mem extends Instruction {

    public static $MEM = 'mem';

    public $address;

    public function __construct($address, $value) {
        parent::__construct(self::$MEM, $value);
        $this->address = $address;
    }

    public function run(Runtime $runtime) {
        $mask = $runtime->variables['mask'];
        $value = str_split(decbin($this->value).'');
        $value = array_pad($value, - count($mask), 0);
        //apply the mask
        $value = array_reduce(array_keys($value), function($res, $pos) use($value, $mask) {
                $bit = $value[$pos];
                $maskBit = $mask[$pos];
                return $res.($maskBit == 'X' ? $bit : $maskBit);
        }, '');
        //back to decimal
        $runtime->variables['mem'][$this->address] = bindec($value);
    }
}