<?php


namespace maesierra\AdventOfCode2020\Day22;


class CombatGame {

    /** @var int[] */
    public $player1 = [];
    /** @var int[] */
    public $player2 = [];

    public $round = 0;

    public $winner = 0;

    /** @var int */
    public $id;

    /**
     * @param int $id
     */
    public function __construct(int $id = 1) {
        $this->id = $id;
    }


    public function run() {
        while (!$this->checkGameEnd()) {
            $this->startRound();
            $played = $this->dealCards();
            $winner = $this->determineRoundWinner($played);
            $this->endRoundAction($winner, $played);
        }
        $this->winner = $this->player1 ? 1 : 2;
        echo "Player {$this->winner} wins\n";
    }

    /**
     * @return int
     */
    public function getWinner(): int {
        return $this->player1 ? 1 : 2;
    }

    public function winnerScore():int {
        $cards = $this->{"player{$this->winner}"};
        return array_reduce(array_keys($cards), function($score, $pos) use ($cards) {
          return $score + $cards[$pos] * (count($cards) - $pos);
        }, 0);
    }

    protected function startRound(): void  {
        $this->round++;
        echo "-- Game {$this->id} Round {$this->round} --\n";
    }

    /**
     * @return int[]
     */
    protected function dealCards():array {
        $played = [];
        echo "Player 1's deck: " . implode(", ", $this->player1) . "\n";
        echo "Player 2's deck: " . implode(", ", $this->player2) . "\n";
        $played[1] = array_shift($this->player1);
        $played[2] = array_shift($this->player2);
        foreach ($played as $player => $card) {
            echo "Player $player plays: {$card}\n";
        }
        return $played;
    }

    /**
     * @param array $played
     * @return int
     */
    protected function determineRoundWinner(array $played): int {
        uasort($played, function ($c1, $c2) {
            return ($c1 <=> $c2) * -1;
        });
        return array_key_first($played);

    }

    /**
     * @param $winner int
     * @param array $played
     */
    protected function endRoundAction(int $winner, array $played): void {
        $cardsInOrder = array_merge([$played[$winner]], array_values(array_filter($played, function ($player) use ($winner) {
            return $player != $winner;
        }, ARRAY_FILTER_USE_KEY)));
        echo "Player $winner wins the game #{$this->id} round!\n";
        $this->{"player$winner"} = array_merge($this->{"player$winner"}, array_values($cardsInOrder));
    }

    /**
     * @return bool
     */
    protected function checkGameEnd(): bool {
        return $this->player1 xor $this->player2;
    }


}