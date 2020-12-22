<?php


namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day22\CombatGame;
use maesierra\AdventOfCode2020\Day22\RecursiveCombatGame;
use ReflectionClass;

class Day22 {

    /**
     * @param string $inputFile
     * @return CombatGame
     */
    private function createGame(string $inputFile, string $gameClass):CombatGame {
        /** @var CombatGame $game */
        $game = (new ReflectionClass($gameClass))->newInstance();
        $player = 0;
        foreach (explode("\n", file_get_contents($inputFile)) as $line) {
            if (!$line) {
                continue;
            }
            if (preg_match('/^Player \d+:$/', $line)) {
                $player++;
                continue;
            }
            $game->{"player$player"}[] = (int) $line;
        }
        return $game;
    }

    public function question1(string $inputFile):int {
        $game = $this->createGame($inputFile, CombatGame::class);
        $game->run();
        return $game->winnerScore();
    }

    public function question2(string $inputFile):int {
        $game = $this->createGame($inputFile, RecursiveCombatGame::class);
        $game->run();
        return $game->winnerScore();
    }
}