<?php

namespace App\Classes\States;

use App\Classes\Game;
use App\Classes\Concerns\Actionable;

class State
{
    use Actionable;

    /**
     * @var Game
     */
    private $game;

    /**
     * @var String
     */
    private $description;

    /**
     * @var State
     */
    private $stateYes;

    /**
     * @var State
     */
    private $stateNo;

    /**
     * @var State
     */
    private $parentState;

    function __construct(string $description = null)
    {
        $this->setDescription($description);
    }

    public static function answerRightState(State $state = null): State
    {
        return State::simpleState('Acertei!', $state);
    }

    public static function simpleState(string $description = null, State $state = null): State
    {
        return (new State('Acertei!'))
            ->setStateYes($state);
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game &$game): self
    {
        $this->game = $game;
        return $this;
    }

    public function getParentState(): ?State
    {
        return $this->parentState;
    }

    public function setParentState(State $parentState): self
    {
        $this->parentState = $parentState;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStateYes(): ?State
    {
        return $this->stateYes;
    }

    public function setStateYes(?State $stateYes): self
    {
        $this->stateYes = $stateYes;
        $this->stateYes->setParentState($this);
        return $this;
    }

    public function getStateNo(): ?State
    {
        return $this->stateNo;
    }

    public function setStateNo(?State $stateNo): self
    {
        $this->stateNo = $stateNo;
        $this->stateNo->setParentState($this);
        return $this;
    }

    protected function changeStates(State $oldState, State $newState): bool
    {
        $changed = false;

        if ($oldState === $this->getStateYes()) {
            $this->setStateYes($newState);
            $changed = true;
        } elseif ($oldState === $this->getStateNo()) {
            $this->setStateNo($newState);
            $changed = true;
        }

        return $changed;
    }

    public function action(): void
    {
        $this->getGame()->info($this->getDescription());

        if (!is_null($this->getStateYes())) {
            $this->getGame()->setState($this->getStateYes());
        } else {
            $this->getGame()->setState();
        }
    }
}
