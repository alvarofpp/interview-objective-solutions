<?php

namespace App\Classes;

use App\Classes\Concerns\Displayable;
use App\Classes\States\FoodState;
use App\Classes\States\QuestionState;
use App\Classes\States\State;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle;

class Game
{
    use InteractsWithIO,
        Displayable;

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
        $this->validateInput = function ($textInput) {
            if (in_array(strtolower($textInput), $this->stopWords)) {
                exit(0);
            }

            return $textInput;
        };
    }

    public static function init(OutputStyle $output = null): Game
    {
        $questionState = (new QuestionState('massa'))
            ->setStateYes(new FoodState('Lasanha'))
            ->setStateNo(new FoodState('Bolo de Chocolate'));
        $firstState = (new State('Pense em um prato que gosta'))
            ->setStateYes($questionState);

        $game = new Game($firstState);
        if (!is_null($output)) {
            $game->setOutput($output);
        }

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
