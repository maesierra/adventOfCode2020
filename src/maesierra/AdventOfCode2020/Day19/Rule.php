<?php


namespace maesierra\AdventOfCode2020\Day19;


class Rule {

    /** @var Rule[][]  */
    public static $cache = [];

    public $id;

    public $expr;

    /** @var Rule[][] */
    public $subRules;

    public $solved = false;

    /**
     * Rule constructor.
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @param string $text
     * @param int $pos
     * @return Match[]
     */
    public function match(string $text, $pos = 0):array {
        $key = "{$this->id}_$pos";
        if ($this->expr) {
            $fragment = substr($text, $pos, strlen($this->expr));
            $matched = $fragment == $this->expr;
            if ($matched) {
                echo "Matched R{$this->id} at $pos\n";
            }
            return $matched ?  [new Match($this, $fragment, $pos)] : [];
        } else if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }
        else {
            $matched = array_reduce($this->subRules, function (&$res, $rules) use ($text, $pos, $key) {
                echo "R{$this->id} trying option: ".implode(", ", array_map(function($r) {return $r->id;}, $rules))."\n";
                /** @var Rule[] $rules */
                //This will hold all position => fragment reducing it for each rule
                //and increasing position/fragment.
                $positions = [$pos => ''];
                foreach ($rules as $rule) {
                    $positions = array_reduce(array_keys($positions), function (&$r, $p) use ($positions, $rule, $text) {
                        echo "R{$this->id} attempting to match {$rule->id} at pos $p\n";
                        foreach ($rule->match($text, $p) as $key => $match) {
                            $newPos = $p + strlen($match->fragment);
                            echo "R{$this->id} matched {$rule->id} up to $newPos\n";
                            $r[$newPos] = $positions[$p] . $match->fragment;
                        }
                        return $r;
                    }, []);
                }
                if ($positions) {
                    //All rules were matched
                    foreach ($positions as $fragment) {
                        echo "Matched R{$this->id} at $pos for $fragment\n";
                        $res[] = new Match($this, $fragment, $pos);
                    }
                }
                return $res;
            }, []);
            self::$cache[$key] = $matched;
            return $matched;
        }
    }

}