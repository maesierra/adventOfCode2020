<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day2\PasswordPolicy;

class Day2 {

    /**
     * Validates all the passwords in the file
     * @param string $inputFile
     * @param $policyClass string class name
     * @return string[]
     */
    protected function validatePasswords(string $inputFile, $policyClass): array
    {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function (&$result, $line) use($policyClass) {
            if (preg_match('/(\d+)-(\d+) (.): (.*)$/', $line, $matches)) {
                $password = $matches[4];
                /** @var PasswordPolicy $policy */
                $policy = (new \ReflectionClass($policyClass))->newInstance($matches[1], $matches[2], $matches[3]);
                if ($policy->validate($password)) {
                    $result[] = $password;
                } else {
                    echo "$line not matched\n";
                }
            }
            return $result;
        }, []);
    }


    /**
     * To try to debug the problem, they have created a list (your puzzle input) of passwords (according to the corrupted database) and the corporate policy when that password was set.
     *
     *    For example, suppose you have the following list:
     *
     *    1-3 a: abcde
     *    1-3 b: cdefg
     *    2-9 c: ccccccccc
     *
     *    Each line gives the password policy and then the password. The password policy indicates the lowest and highest number of times a given letter must appear for the password to be valid. For example, 1-3 a means that the password must contain a at least 1 time and at most 3 times.
     *
     *    In the above example, 2 passwords are valid. The middle password, cdefg, is not; it contains no instances of b, but needs at least 1. The first and third passwords are valid: they contain one a or nine c, both within the limits of their respective policies.
     *
     *    How many passwords are valid according to their policies?
     *
     * @param $inputFile string file containing a number per line
     * @return string[] valid entries
     * @throws \Exception
     */
    public function question1($inputFile) {
        return $this->validatePasswords($inputFile, Day2\Policy1::class);
    }

    /**
     * Each policy actually describes two positions in the password, where 1 means the first character, 2 means the second character, and so on. (Be careful; Toboggan Corporate Policies have no concept of "index zero"!) Exactly one of these positions must contain the given letter. Other occurrences of the letter are irrelevant for the purposes of policy enforcement.
     *
     * Given the same example list from above:
     *
     * 1-3 a: abcde is valid: position 1 contains a and position 3 does not.
     * 1-3 b: cdefg is invalid: neither position 1 nor position 3 contains b.
     * 2-9 c: ccccccccc is invalid: both position 2 and position 9 contain c.
     *
     *    How many passwords are valid according to their policies?
     *
     * @param $inputFile string file containing a number per line
     * @return string[] valid entries
     * @throws \Exception
     */
    public function question2($inputFile) {
        return $this->validatePasswords($inputFile, Day2\Policy2::class);
    }

}