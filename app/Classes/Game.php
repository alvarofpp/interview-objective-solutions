<?php

namespace App\Classes;

use App\Classes\States\FoodState;
use App\Classes\States\QuestionState;
use App\Classes\States\State;
use Illuminate\Console\Concerns\InteractsWithIO;

class Game
{
    use InteractsWithIO;

    /**
     * @var State
     */
    private $initialState;

    /**
     * @var State
     */
    private $currentState;

    function __construct(State $initialState)
    {
        $this->setInitialState($initialState);
    }

    public static function init($input, $output): Game
    {
        $firstState = new State('Pense em um prato que gosta');
        $firstQuestionState = new QuestionState('massa');
        $lasagnaFoodState = new FoodState('Lasanha');
        $cakeFoodState = new FoodState('Bolo de Chocolate');

        $firstState->setStateYes($firstQuestionState);
        $firstQuestionState->setStateYes($lasagnaFoodState);
        $firstQuestionState->setStateNo($cakeFoodState);

        $game = new Game($firstState);
        $game->setInput($input);
        $game->setOutput($output);

        return $game;
    }

    public function getInitialState(): State
    {
        return $this->initialState;
    }

    public function setInitialState(State $initialState): self
    {
        $this->initialState = $initialState;
        return $this->setState($this->initialState);
    }

    public function getState(): ?State
    {
        return $this->currentState;
    }

    public function setState(State $state = null): self
    {
        $this->currentState = $state;

        if (!$this->isFinish()) {
            $this->currentState->setGame($this);
        }

        return $this;
    }

    public function isFinish(): bool
    {
        return is_null($this->getState());
    }
}
