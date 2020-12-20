<?php


namespace maesierra\AdventOfCode2020\Day19;


class Match {

    /** @var Rule */
    public $rule;
    public $fragment;
    public $position;

    /**
     * Match constructor.
     * @param Rule $rule
     * @param $position
     * @param $fragment
     */
    public function __construct(Rule $rule, string $fragment, int $position)
    {
        $this->rule = $rule;
        $this->fragment = $fragment;
        $this->position = $position;
    }


}