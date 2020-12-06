<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day4\Rule;

class Day4 {


    /**
     * Parses all the passports int he file.
     * Passport fields are the following:
     * - byr (Birth Year)
     * - iyr (Issue Year)
     * - eyr (Expiration Year)
     * - hgt (Height)
     * - hcl (Hair Color)
     * - ecl (Eye Color)
     * - pid (Passport ID)
     * - cid (Country ID)
     *
     * Each passport is represented as a sequence of key:value pairs separated by spaces or newlines. Passports are separated by blank lines.
     * @param string $inputFile
     * @param \Closure $validator predicate taking password fields as a map
     * @return array[][] array containing the valid passports. the passport is an associative array for the given fields
     */
    private function readValidPasswordsFromFile(string $inputFile, \Closure $validator) {
        $separated = array_reduce(explode("\n", file_get_contents($inputFile)),
            function (&$result, $line) {
                if (!$result && $line) {
                    $result[] = $line;
                    return $result;
                }
                if ($line == '') {
                    $result[] = '';
                } else {
                    $last = count($result) - 1;
                    $result[$last] = "{$result[$last]} $line";
                }
                return $result;
            }, []);
        $passports = array_map(function($line) {
            preg_match_all('/( ?([^:]+):([^ ]+))/', $line, $matches);
            return array_reduce(array_keys($matches[0]), function(&$result, $pos) use($matches) {
                $key = $matches[2][$pos];
                $value = $matches[3][$pos];
                $result[$key] = $value;
                return $result;
            }, []);
        }, $separated);
        return array_filter($passports, $validator);
    }


    /**
     * Read all the passwords and return all of them containing the required fields
     *
     * @param $inputFile string file containing a number per line
     * @return int Number of valid passports
     * @throws \Exception
     */
    public function question1($inputFile) {
        $requiredFields = [
            "byr" => true,
            "iyr" => true,
            "eyr" => true,
            "hgt" => true,
            "hcl" => true,
            "ecl" => true,
            "pid" => true,
        ];
        $passports = $this->readValidPasswordsFromFile($inputFile, function($p) use($requiredFields) {
            $fields = array_diff_key($requiredFields, $p);
            return count($fields) == 0;
        });
        return count($passports);
    }

    /**
     * Read and count the valid passwords according to this rules
     *
     *
     *   byr (Birth Year) - four digits; at least 1920 and at most 2002.
     *   iyr (Issue Year) - four digits; at least 2010 and at most 2020.
     *   eyr (Expiration Year) - four digits; at least 2020 and at most 2030.
     *   hgt (Height) - a number followed by either cm or in:
     *   If cm, the number must be at least 150 and at most 193.
     *   If in, the number must be at least 59 and at most 76.
     *   hcl (Hair Color) - a # followed by exactly six characters 0-9 or a-f.
     *   ecl (Eye Color) - exactly one of: amb blu brn gry grn hzl oth.
     *   pid (Passport ID) - a nine-digit number, including leading zeroes.
     *   cid (Country ID) - ignored, missing or not.
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile) {
        $rules = [
            'byr' => new Rule(true, '/^\d{4}$/', function($value) {
                return $value >= 1920 && $value <= 2002;
            }),
            'iyr' => new Rule(true, '/^\d{4}$/', function($value) {
                return $value >= 2010 && $value <= 2020;
            }),
            'eyr' => new Rule(true, '/^\d{4}$/', function($value) {
                return $value >= 2020 && $value <= 2030;
            }),
            'hgt' => new Rule(true, '/^(\d+)(in|cm)$/', function($value, $matches) {
                $value = $matches[1];
                if ($matches[2] == 'cm') {
                    return $value >= 150 && $value <= 193;
                } else {
                    return $value >= 59 && $value <= 76;
                }
            }),
            'hcl' => new Rule(true, '/^#[0-9a-f]{6}$/'),
            'ecl' => new Rule(true, '/^amb|blu|brn|gry|grn|hzl|oth$/'),
            'pid' => new Rule(true, '/^\d{9}$/'),
            'cid' => new Rule(false)
        ];
        $passwords = $this->readValidPasswordsFromFile($inputFile, function($password) use ($rules) {
            return array_reduce(array_keys($rules), function($current, $field) use($password, $rules) {
                return $current && $rules[$field]->apply($password[$field] ?? null);
            }, true);
        });
        return count($passwords);
    }
}