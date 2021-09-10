<?php

namespace App\Classes\States;

class QuestionState extends State
{
    public function action(): void
    {
        $confirm = $this->getGame()->confirm("O prato que você pensou é {$this->getDescription()}?");
        $newState = $confirm ? $this->getStateYes() : $this->getStateNo();
        $this->getGame()->setState($newState);
    }
}
