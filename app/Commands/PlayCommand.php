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
    protected $description = 'Init the Gourmet Game';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Gourmet game.');
        $game = Game::init($this->input, $this->getOutput());

        while (!$game->isFinish()) {
            $state = $game->getState();
            $state->action();
        }

        exit(0);
    }
}
