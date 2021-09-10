<?php

use App\Classes\Game;
use App\Classes\States\FoodState;
use App\Classes\States\QuestionState;
use App\Classes\States\State;

test('game example from init method', function () {
    $game = Game::init();
    $state = $game->getState();
    expect($state)->toBeInstanceOf(State::class);
    expect($state->getDescription())->toBe('Pense em um prato que gosta');

    $state->action();
    $state = $game->getState();
    expect($state)->toBeInstanceOf(QuestionState::class);
    expect($state->getDescription())->toBe('massa');

    $stateYes = $state->getStateYes();
    expect($stateYes)->toBeInstanceOf(FoodState::class);
    expect($stateYes->getDescription())->toBe('Lasanha');

    $stateNo = $state->getStateNo();
    expect($stateNo)->toBeInstanceOf(FoodState::class);
    expect($stateNo->getDescription())->toBe('Bolo de Chocolate');
});

test('finish the game', function () {
    $game = Game::init();
    $game->setState();
    expect($game->isFinish())->toBeTrue();
});
