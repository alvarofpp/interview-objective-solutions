<?php

namespace App\Classes\States;

class FoodState extends State
{
    public function action(): void
    {
        $confirm = $this->getGame()
            ->displayConfirm("O prato que você pensou é {$this->getDescription()}? (sim/não)");
        $newState = $confirm ? self::answerRightState($this->getGame()->getInitialState()) : $this->collectFood();

        $this->getGame()->setState($newState);
    }

    private function collectFood(): State
    {
        $foodName = $this->getGame()
            ->displayAsk('Qual prato você pensou?');
        $adjective = $this->getGame()
            ->displayAsk("{$foodName} é ______ mas {$this->getDescription()} não");
        $parentState = $this->getParentState();

        $questionState = (new QuestionState($adjective))
            ->setStateYes(new self($foodName))
            ->setStateNo($this);
        $parentState->changeStates($this, $questionState);

        return $this->getGame()->getInitialState();
    }
}
