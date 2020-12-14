<?php


namespace maesierra\AdventOfCode2020\Day14;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class MemWithAddressDecoder extends Instruction {

    public static $MEM = 'mem';

    public $address;

    public function __construct($address, $value) {
        parent::__construct(self::$MEM, $value);
        $this->address = $address;
    }

    public function run(Runtime $runtime) {
        $mask = $runtime->variables['mask'];
        $address = str_split(decbin($this->address).'');
        $address = array_pad($address, - count($mask), 0);
        //apply the mask
        $addresses = array_reduce(array_reverse(array_keys($address)), function($res, $pos) use($address, $mask) {
                $maskBit = $mask[$pos];
                switch ($maskBit) {
                    case '0':
                        $bits = [$address[$pos]];
                        break;
                    case '1':
                        $bits = [1];
                        break;
                    default:
                        $bits = [0, 1];
                }
                $r = [];
                foreach ($bits as $bit) {
                    if (!$res) {
                        $r[] = $bit;
                    } else {
                        foreach ($res as $option) {
                            $r[] = ($bit ? '1' : '0') . $option;
                        }
                    }
                }
                return $r;
        }, []);
        foreach ($addresses as $addr) {
            $runtime->variables['mem'][bindec($addr)] = $this->value;
        }

    }
}