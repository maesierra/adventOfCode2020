<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;


class Node {
    /** @var Node[] */
    public $next;
    public $parent;
    public $value;

    /**
     * Node constructor.
     * @param $value
     */
    public function __construct($value, $parent) {
        $this->value = $value;
        $this->parent = $parent;
    }

    public function count() {
        if (!$this->next) {
            return 1;
        } else {
            return array_reduce($this->next, function($sum, $node) {
                return $sum + $node->count();
            }, 0);
        }
    }

}

class Day10 {

    public $cache = [];
    public $nodeCache = [];


    /**
     * Returns is the number of 1-jolt differences multiplied by the number of 3-jolt differences
     * @param $inputFile
     * @param $size
     * @return int
     */
    public function question1($inputFile): int {
        $distribution = $this->calculateDistribution($inputFile);
        return $distribution[1] * $distribution[3];
    }

    /**
     * @param string $inputFile
     * @param int $number
     * @return int
     */
    public function question2(string $inputFile):int {
        $numbers = explode("\n", file_get_contents($inputFile));
        sort($numbers);
        return $this->countChains($numbers);
    }


    /**
     * @param string $inputFile
     * @return int[]
     */
    public function calculateDistribution(string $inputFile): array
    {
        $joltages = explode("\n", file_get_contents($inputFile));
        sort($joltages);
        $max = end($joltages);
        $next = 0;
        $joltages = array_combine($joltages, $joltages);
        $res = [1 => 0, 2 => 0, 3 => 1];
        $chain = [];
        $current = 0;
        while ($next < $max) {
            foreach (array_keys($res) as $diff) {
                $next = $joltages[$current + $diff] ?? 0;
                if ($next) {
                    $chain[] = $next;
                    $res[$diff]++;
                    $current = $next;
                    break;
                }
                $next = next($joltages);
            }
        }
        return $res;
    }

    public function calculateChains( array $chain) {
        $startingValue = $chain[0];
        $result = $this->cache[$startingValue] ?? null;
        if ($result) {
            return $result;
        }
        if (count($chain) == 2) {
            return  $chain[1];
        }
        $candidates = array_filter(array_slice($chain, 1, 3), function($n) use($startingValue) {
            $diff = $n - $startingValue;
            return $diff >= 1 && $diff <= 3;
        });
        $result = array_reduce($candidates, function (&$result, $next) use($chain) {
            $result[$next] = $this->calculateChains(array_slice($chain, array_search($next, $chain)));
            return $result;
        }, []);
        $this->cache[$startingValue] = $result;
        return $result;
    }



    public function createTree( array $chain, $parent = null) {
        $startingValue = $chain[0];
        $result = $this->nodeCache[$startingValue] ?? null;
        if ($result) {
            return $result;
        }
        if (count($chain) == 2) {
            return  new Node($chain[1], $parent);
        }
        $candidates = array_filter(array_slice($chain, 1, 3), function($n) use($startingValue) {
            $diff = $n - $startingValue;
            return $diff >= 1 && $diff <= 3;
        });
        $node = new Node($startingValue, $parent);
        $node->next = array_map(function($next) use ($chain, $node) {
            return $this->createTree(array_slice($chain, array_search($next, $chain)), $node);
        }, $candidates);
        $this->nodeCache[$startingValue] = $result;
        return $node;
    }

    public function countChains(array $chains) {
        $tree = $this->createTree($chains);
        return $tree->count();
    }
}