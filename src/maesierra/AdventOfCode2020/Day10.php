<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;



use maesierra\AdventOfCode2020\Day10\Node;

class Day10 {

    public $cache = [];
    public $nodeCache = [];
    public $countCache = [];


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
        array_unshift($numbers, 0);
        $numbers[] = end($numbers) + 3;
        $this->countCache = [];
        $node = $this->createTree($numbers);
        return $this->count($node);
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
        $current = 0;
        while ($next < $max) {
            foreach (array_keys($res) as $diff) {
                $next = $joltages[$current + $diff] ?? 0;
                if ($next) {
                    $res[$diff]++;
                    $current = $next;
                    break;
                }
                $next = next($joltages);
            }
        }
        return $res;
    }



    public function createTree( array $chain, $parent = null):Node {
        $current = $chain[0];
        $result = $this->nodeCache[$current] ?? null;
        if ($result) {
            return $result;
        }
        if (count($chain) == 2) {
            $node = new Node($chain[0], $parent);
            $node->next = [new Node($chain[1], $node)];
            $this->nodeCache[$current] = $node;
            return $node;
        }
        $candidates = array_filter(array_slice($chain, 1, 3), function($n) use($current) {
            $diff = $n - $current;
            return $diff >= 1 && $diff <= 3;
        });
        $node = new Node($current, $parent);
        $node->next = array_map(function($next) use ($chain, $node) {
            return $this->createTree(array_slice($chain, array_search($next, $chain)), $node);
        }, $candidates);
        $this->nodeCache[$current] = $node;
        return $node;
    }

    public function count(Node $node): int {
        echo "counting node {$node->value}...\n";
        $result = $this->countCache[$node->value] ?? 0;
        if (!$result) {
            if (!$node->next) {
                $result = 1;
            } else {
                $result = array_reduce($node->next, function ($sum, $n) {
                    return $sum + $this->count($n);
                }, 0);
            }
            $this->countCache[$node->value] = $result;
        }
        echo "counting node {$node->value} => $result\n";
        return $result;
    }

}