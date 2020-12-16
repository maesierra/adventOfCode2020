<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day15\Rule;

class Day16 {


    /**
     * Parses all rules and tickets
     * Example:
     *   class: 1-3 or 5-7
     *   row: 6-11 or 33-44
     *   seat: 13-40 or 45-50
     *
     *   your ticket:
     *   7,1,14
     *
     *   nearby tickets:
     *   7,3,47
     *   40,4,50
     * @param string $inputFile
     * @return array[][] pos 0 => Rule[], pos 1 => int[] (ticket 0 is the one marked with your ticket)
     */
    private function readRulesAndTickes(string $inputFile, $valid = true) {
        list($rules, $tickets) = array_reduce(explode("\n", file_get_contents($inputFile)),
            function (&$result, $line) {
                $line = trim($line);
                if (!$line) {
                    return $result;
                }
                if (preg_match('/^(.+): (\d+)-(\d+) or (\d+)-(\d+)$/', $line, $matches)) {
                    $result[0][] = new Rule($matches[1], [[$matches[2], $matches[3]], [$matches[4], $matches[5]]]);
                } else if (preg_match('/(\d+,)*(\d+)/', $line)) {
                    $result[1][] = explode(',', $line);
                }
                return $result;
            }, [[], []]);
        if ($valid) {
            $tickets = array_filter($tickets, function ($ticket) use ($rules) {
                $validValues = count(array_filter($ticket, function ($value) use ($rules) {
                    return array_reduce($rules, function ($res, $rule) use ($value) {
                        return $res || $rule->validate($value);
                    }, false);
                }));
                return $validValues == count($ticket);
            });
        }
        return [$rules, $tickets];
    }


    /**
     * Read all the rules and tickets, ignore first ticket and sum all the invalid fields
     *
     * @param $inputFile string file
     * @return int
     */
    public function question1($inputFile) {
        /** @var $rules Rule[] */
        list($rules, $tickets) = $this->readRulesAndTickes($inputFile, false);
        $tickets = array_slice($tickets, 1);
        return array_reduce($tickets, function ($sum, $ticket) use($rules) {
            return array_reduce($ticket, function($s, $value) use($rules) {
                $anyValid = array_reduce($rules, function ($res, $rule) use($value) {
                    return $res || $rule->validate($value);
                }, false);
                return (!$anyValid ? $value : 0) + $s;

            }, $sum);
        }, 0);
    }

    public function question2(string $inputFile) {
        $ticket = $this->getTicket($inputFile);
        $selected = array_filter($ticket, function($key) {
            return strpos($key, 'departure ') === 0;
        }, ARRAY_FILTER_USE_KEY);
        return array_product($selected);
    }

    public function getTicket(string $inputFile) {
        /** @var $rules Rule[] */
        list($rules, $tickets) = $this->readRulesAndTickes($inputFile);
        $ticket = array_shift($tickets);
        //Map all the values to each position
        $map = array_reduce(array_keys($tickets), function(&$result, $pos) use($tickets) {
            $result[$pos] = array_column($tickets, $pos);
            return $result;
        }, []);
        //Get all the valid rules for each position
        $candidates = array_map(function($values) use($rules) {
            return array_reduce($rules, function (&$result, $rule) use ($values) {
                /** @var Rule $rule */
                foreach ($values as $value) {
                    if (!$rule->validate($value)) {
                        return $result;
                    }
                }
                $result[] = $rule->name;
                return $result;
            }, []);
        }, $map);
        $map = [];
        while ($candidates) {
            //Find all the positions they have only one rule
            $solved = array_filter($candidates, function ($rules) {
                return count($rules) == 1;
            });
            if (count($solved) == 0) {
                die("No more candidates");
            }
            foreach ($solved as $pos => $rule) {
                $rule = reset($rule);
                $map[$pos] = $rule;
                //Those rules need to be removed from other
                foreach ($candidates as $i => $rules) {
                    $found = array_search($rule, $rules);
                    if ($found !== false) {
                        unset($candidates[$i][$found]);
                    }
                }
            }
            $candidates = array_filter($candidates, function($rules) {
                return $rules ? true :false;
            });

        }
        return array_reduce(array_keys($ticket), function(&$result, $pos) use($ticket, $map) {
            /** @var string $rule */
            $rule = $map[$pos];
            $result[$rule] = $ticket[$pos];
            return $result;
        });
    }
}