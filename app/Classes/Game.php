<?php

namespace App\Classes;

use App\Classes\States\FoodState;
use App\Classes\States\QuestionState;
use App\Classes\States\State;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle;

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

    /**
     * @var \Closure
     */
    protected $validateInput;

    /**
     * @var string[]
     */
    private $stopWords = [
        'exit',
        'cancelar',
    ];

    /**
     * @var string
     */
    private $trueAnswerRegex = '/^s/i';

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

    public static function init(OutputStyle $output): Game
    {
        $firstState = new State('Pense em um prato que gosta');
        $firstQuestionState = new QuestionState('massa');
        $lasagnaFoodState = new FoodState('Lasanha');
        $cakeFoodState = new FoodState('Bolo de Chocolate');

        $firstState->setStateYes($firstQuestionState);
        $firstQuestionState->setStateYes($lasagnaFoodState);
        $firstQuestionState->setStateNo($cakeFoodState);

        $game = new Game($firstState);
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

    public function getStopWords(): array
    {
        return $this->stopWords;
    }

    public function setStopWords(array $stopWords): self
    {
        $this->stopWords = $stopWords;
        return $this;
    }

    public function addStopWord(string $stopWord): self
    {
        $this->stopWords[] = $stopWord;
        return $this;
    }

    public function isFinish(): bool
    {
        return is_null($this->getState());
    }

    public function ask(string $question): string
    {
        return $this->getOutput()->ask($question, '', $this->validateInput);
    }

    public function confirm(string $question): bool
    {
        $answer = $this->getOutput()->ask($question, 'não', $this->validateInput);
        return $this->isTrueAnswer($answer);
    }

    private function isTrueAnswer(string $answer): bool
    {
        if (\is_bool($answer)) {
            return $answer;
        }

        $answerIsTrue = (bool) preg_match($this->trueAnswerRegex, $answer);

        return '' === $answer || $answerIsTrue;
    }
}
