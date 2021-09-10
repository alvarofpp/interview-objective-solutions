<?php

namespace App\Classes\Concerns;

trait Displayable
{
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

    public function displayAsk(string $question, string $default = ''): string
    {
        $answer = '';

        if ($this->checkIfOutputExist()) {
            $answer = $this->getOutput()->ask($question, $default, $this->validateInput);
        }

        return $answer;
    }

    public function displayConfirm(string $question): bool
    {
        $confirm = false;

        if ($this->checkIfOutputExist()) {
            $answer = $this->displayAsk($question, 'não');
            $confirm = $this->isTrueAnswer($answer);
        }

        return $confirm;
    }

    private function isTrueAnswer(string $answer): bool
    {
        if (\is_bool($answer)) {
            return $answer;
        }

        $answerIsTrue = (bool) preg_match($this->trueAnswerRegex, $answer);

        return '' === $answer || $answerIsTrue;
    }

    private function checkIfOutputExist(): bool
    {
        return !is_null($this->getOutput());
    }
}
