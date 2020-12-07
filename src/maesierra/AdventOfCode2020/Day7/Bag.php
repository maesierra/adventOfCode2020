<?php


namespace maesierra\AdventOfCode2020\Day7;


class Bag {

    /** @var string */
    public $colour;

    /** @var  Bag[]*/
    private $allowed;

    /** @var int[] */
    private $numberAllowed;

    /**
     * Bag constructor.
     * @param string $colour
     */
    public function __construct(string $colour) {
        $this->colour = $colour;
        $this->allowed = [];
        $this->numberAllowed = [];
    }

    /**
     * Allows a number of bags in the current bag
     * @param int $number
     * @param Bag $bag
     */
    public function addAllowed(int $number, Bag $bag) {
        $this->allowed[$bag->colour] = $bag;
        $this->numberAllowed[$bag->colour] = $number;
    }


    /**
     * Check if the bag can contain the given colour bag
     * @param string $colour
     * @return bool
     */
    public function canContain(string $colour) {
        if (in_array($colour, array_keys($this->allowed))) {
            return true;
        }
        foreach ($this->allowed as $bag) {
            if ($bag->canContain($colour)) {
                return  true;
            }
        }
        return false;
    }

    /**
     * @return int
     */
    public function count(): int {
        if (!$this->allowed) {
            return 1;
        }
        return array_reduce($this->allowed, function($c, $bag) {
            /** @var Bag $bag */
            return $c + $this->numberAllowed[$bag->colour] * ($bag->count() + ($bag->allowed ? 1 : 0));
        }, 0);
    }

}