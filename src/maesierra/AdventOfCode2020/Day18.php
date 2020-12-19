<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;



use ParserGenerator\Parser;
use ParserGenerator\SyntaxTreeNode\Branch;
use ParserGenerator\SyntaxTreeNode\Leaf;

class Day18 {


    public function evaluateExpression(Parser $parser, string $expr):int {
        $expr = str_replace(" ", "", $expr);
        $parsed = $parser->parse($expr);
        return $this->evaluateNode($parsed->getSubnode(0));
    }

    /**
     * @param $node Branch|Leaf
     * @return int
     */
    private function evaluateNode($node):int {
        switch ($node->getType()) {
            case 'A':
            case 'B':
                $value1 = $this->evaluateNode($node->getSubnode(0));
                if (count($node->getSubnodes()) == 3) {
                    $op = $node->getSubnode(1)->getContent();
                    $value2 = $this->evaluateNode($node->getSubnode(2));
                    return $op == '+' ? $value1 + $value2 : $value1 * $value2;
                } else {
                    return  $value1;
                }

            case 'O':
                if (count($node->getSubnodes()) == 3) {
                    return $this->evaluateNode($node->getSubnode(1));
                } else {
                    return $this->evaluateNode($node->getSubnode(0));
                }
            case 'N':
                return $node->getSubnode(0)->getContent();
        }
    }
    public function question1(string $inputFile):int {
        $parser = new Parser(
            'start :=> A.
                     A :=> A "*" O
                       :=> A "+" O
                       :=> O.
                     O :=> N 
                       :=> "("A")".
                     N :=> /\d+/.');

        return array_reduce(explode("\n", file_get_contents($inputFile)),
            function ($sum, $line) use($parser) {
                if (!trim($line)) {
                    return $sum;
                }
                return $sum + $this->evaluateExpression($parser, $line);
        }, 0);
    }

    public function question2(string $inputFile):int {
        $parser = new Parser(
            'start :=> A.
                     A :=> A "*" B
                       :=> B.
                     B :=> B "+" O
                       :=> O.                       
                     O :=> N 
                       :=> "("A")".
                     N :=> /\d+/.');

        return array_reduce(explode("\n", file_get_contents($inputFile)),
            function ($sum, $line) use($parser) {
                if (!trim($line)) {
                    return $sum;
                }
                return $sum + $this->evaluateExpression($parser, $line);
            }, 0);
    }


}