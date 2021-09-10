<?php

namespace App\Commands;

use App\Classes\Game;
use LaravelZero\Framework\Commands\Command;

class PlayCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'play';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Starts the Gourmet game';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('--- GOURMET GAME ---');
        $this->alert('Você pode encerrar o jogo a qualquer momento digitando "exit" ou "cancelar" (sem as aspas).');
        $game = Game::init($this->getOutput());

        while (!$game->isFinish()) {
            $state = $game->getState();
            $state->action();
        }

        exit(0);
    }
}
