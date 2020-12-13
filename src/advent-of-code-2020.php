<?php

use maesierra\AdventOfCode2020\Day1;
use maesierra\AdventOfCode2020\Day10;
use maesierra\AdventOfCode2020\Day11;
use maesierra\AdventOfCode2020\Day12;
use maesierra\AdventOfCode2020\Day13;
use maesierra\AdventOfCode2020\Day2;
use maesierra\AdventOfCode2020\Day3;
use maesierra\AdventOfCode2020\Day4;
use maesierra\AdventOfCode2020\Day5;
use maesierra\AdventOfCode2020\Day6;
use maesierra\AdventOfCode2020\Day7;
use maesierra\AdventOfCode2020\Day8;
use maesierra\AdventOfCode2020\Day9;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require __DIR__ . '/../vendor/autoload.php';

if (php_sapi_name() != "cli") {
    die ("Command line only<br/>");
}


$app = new Application("advent-of-code-2020");

/**
 * @param $day int
 * @param $question int
 * @param $run \Closure
 * @return Command
 */
function runQuestion($day, $question, $run)
{
    return new class($day, $question, $run) extends Command {
        /** @var int */
        private $day;
        /** @var int */
        private $question;
        /** @var Closure */
        private $run;

        public function __construct($day, $question, $run) {
            parent::__construct("day{$day}-question{$question}");
            $this->day = $day;
            $this->question = $question;
            $this->run = $run;
        }

        protected function configure()
        {
            $this->setDescription("Runs day {$this->day} question {$this->question}")
                ->addArgument(
                    'file',
                    InputArgument::REQUIRED,
                    'File to process'
                );

        }

        public function execute(InputInterface $input, OutputInterface $output) {
            $r = $this->run;
            $result = $r($input->getArgument("file"));
            $output->writeln("Result is " . $result);
        }
    };
}

$app->add(runQuestion(1, 1, function($file) {
    return (new Day1())->question1($file);
}));
$app->add(runQuestion(1, 2, function($file) {
    return (new Day1())->question2($file);
}));
$app->add(runQuestion(2, 1, function($file) {
    $validPasswords = (new Day2())->question1($file);
    return count($validPasswords);
}));
$app->add(runQuestion(2, 2, function($file) {
    $validPasswords = (new Day2())->question2($file);
    return count($validPasswords);
}));
$app->add(runQuestion(3, 1, function($file) {
    return (new Day3())->question1($file);
}));
$app->add(runQuestion(3, 2, function($file) {
    return (new Day3())->question2($file);
}));
$app->add(runQuestion(4, 1, function($file) {
    return (new Day4())->question1($file);
}));
$app->add(runQuestion(4, 2, function($file) {
    return (new Day4())->question2($file);
}));
$app->add(runQuestion(5, 1, function($file) {
    return (new Day5())->question1($file);
}));
$app->add(runQuestion(5, 2, function($file) {
    return (new Day5())->question2($file);
}));
$app->add(runQuestion(6, 1, function($file) {
    return (new Day6())->question1($file);
}));
$app->add(runQuestion(6, 2, function($file) {
    return (new Day6())->question2($file);
}));
$app->add(runQuestion(7, 1, function($file) {
    return (new Day7())->question1($file);
}));
$app->add(runQuestion(7, 2, function($file) {
    return (new Day7())->question2($file);
}));
$app->add(runQuestion(8, 1, function($file) {
    return (new Day8())->question1($file);
}));
$app->add(runQuestion(8, 2, function($file) {
    return (new Day8())->question2($file);
}));
$app->add(runQuestion(9, 1, function($file) {
    return (new Day9())->question1($file, 25);
}));
$app->add(runQuestion(9, 2, function($file) {
    return (new Day9())->question2($file, 675280050);
}));
$app->add(runQuestion(10, 1, function($file) {
    return (new Day10())->question1($file);
}));
$app->add(runQuestion(10, 2, function($file) {
    return (new Day10())->question2($file);
}));
$app->add(runQuestion(11, 1, function($file) {
    return (new Day11())->question1($file);
}));
$app->add(runQuestion(11, 2, function($file) {
    return (new Day11())->question2($file);
}));
$app->add(runQuestion(12, 1, function($file) {
    return (new Day12())->question1($file);
}));
$app->add(runQuestion(12, 2, function($file) {
    return (new Day12())->question2($file);
}));
$app->add(runQuestion(13, 1, function($file) {
    $res = (new Day13())->question1($file);
    $id = array_keys($res)[0];
    $wait = array_values($res)[0];
    echo "BUS $id => $wait\n";
    return $id * $wait;
}));
$app->add(runQuestion(13, 2, function($file) {
    return (new Day13())->question2($file);
}));
$app->run();