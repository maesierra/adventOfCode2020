<?php


namespace maesierra\AdventOfCode2020\Day22;


class RecursiveCombatGame extends CombatGame {


    private static $gameIdSeed = 1;
    /** @var int[][][] */
    private $history = [];


    protected function checkGameEnd(): bool {
        $state = [
            1 => $this->player1,
            2 => $this->player2
        ];
        foreach ($this->history as $round) {
            if ($round == $state) {
                $this->winner = 1;
                return true;
            }
        }
        $this->history[] = $state;
        return parent::checkGameEnd();
    }

    protected function determineRoundWinner(array $played): int {
        if ($played[1] <= count($this->player1) && $played[2] <= count($this->player2)) {
            //Create the subgame
            RecursiveCombatGame::$gameIdSeed++;
            $game = new RecursiveCombatGame(RecursiveCombatGame::$gameIdSeed);
            $game->player1 = array_slice($this->player1, 0, $played[1]);
            $game->player2 = array_slice($this->player2, 0, $played[2]);
            $game->run();
            return $game->getWinner();
        } else {
            return parent::determineRoundWinner($played);
        }
    }
}