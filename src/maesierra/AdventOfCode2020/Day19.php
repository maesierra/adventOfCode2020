<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;



use maesierra\AdventOfCode2020\Day19\Rule;

class Day19 {



    /**
     * Reads the input file and splits it into rules and messages
     * @param string $inputFile
     * @return array
     */
    private function readFile(string $inputFile): array {
        return array_reduce(explode("\n", file_get_contents($inputFile)),
            function (&$result, $line) {
                if (trim($line)) {
                    if (preg_match('/^\d+:/', $line)) {
                        $result[0][] = $line;
                    } else {
                        $result[1][] = $line;
                    }
                }
                return $result;
            }, [[], []]);
    }

    /**
     * @param string[] $rules lines containing rules
     * @return Rule[] rules
     */
    private function parseRules(array $rules):array {
        /** @var Rule[] $rules */
        $rules = array_reduce($rules, function (&$res, $ruleDef) {
            if (!preg_match('/^(\d+): (.*)$/', $ruleDef, $matches)) {
                return $res;
            }
            $id = $matches[1];
            $ruleDef = trim($matches[2]);
            /** @var Rule $rule */
            $rule = $res[$id] ?? null;
            if (!$rule) {
                $rule = new Rule($id);
                $res[$id] = $rule;
            }
            if (preg_match('/^"(.*)"$/', $ruleDef, $matches)) {
                $rule->expr = $matches[1];
                $rule->solved = true;
            } else {
                $rule->subRules = array_map(function($option) use(&$res) {
                    $option = trim($option);
                    $subRules = [];
                    foreach (explode(" ", $option) as $r) {
                        $r = trim($r);
                        if (!$r) {
                            continue;
                        }
                        if (!isset($res[$r])) {
                            $res[$r] = new Rule($r);
                        }
                        $subRules[] = $res[$r];
                    }
                    return $subRules;
                }, explode("|", $ruleDef));

            }
            return $res;
        }, []);
        return $rules;
    }


    /**
     * @param $messages
     * @param Rule[] $rules
     * @return mixed
     */
    private function verifyMessages($messages, array $rules) {
        $parentRule = $this->parentRule($rules);
        return array_reduce($messages, function ($sum, $message) use ($parentRule) {
                Rule::$cache = [];
                foreach ($parentRule->match($message) as $match) {
                    if ($match->fragment == $message) {
                        return $sum + 1;
                    }
                }
                return $sum;
        }, 0);
    }


    /**
     * @param array $rules
     * @return mixed
     */
    private function parentRule(array $rules) {
        //need to find the parent rule, a rule that is not referenced by any other rule
        $parent = $rules;
        foreach ($rules as $rule) {
            foreach ($rule->subRules as $options) {
                foreach ($options as $r) {
                    unset($parent[$r->id]);
                }
            }
        }
        return reset($parent);
    }



    public function question1(string $inputFile):int {
        list($rules, $messages) = $this->readFile($inputFile);
        return $this->verifyMessages($messages, $this->parseRules($rules));
    }

    public function question2(string $inputFile):int {
        list($rules, $messages) = $this->readFile($inputFile);
        foreach ($rules as $pos => $rule) {
            if (preg_match('/^8:/', $rule)) {
                $rules[$pos] = '8: 42 | 42 8';
            } else if (preg_match('/^11:/', $rule)) {
                $rules[$pos] = '11: 42 31 | 42 11 31';
            }
        }
        return $this->verifyMessages($messages, $this->parseRules($rules));
    }

}