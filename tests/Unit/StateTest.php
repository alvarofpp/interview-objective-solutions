<?php

use App\Classes\States\FoodState;
use App\Classes\States\QuestionState;

test('changeStates method', function () {
    $foodDescriptionOne = 'Comida1';
    $foodDescriptionTwo = 'Comida2';
    $foodDescriptionThree = 'Comida3';

    $state = (new QuestionState('massa'))
        ->setStateYes(new FoodState($foodDescriptionOne))
        ->setStateNo(new FoodState($foodDescriptionTwo));

    $stateYes = $state->getStateYes();
    $newFood = new FoodState($foodDescriptionThree);
    $questionState = (new QuestionState('boo'))
        ->setStateYes($newFood)
        ->setStateNo($stateYes);
    $state->changeStates($stateYes, $questionState);

    $newStateYes = $state->getStateYes();
    expect($newStateYes)
        ->toBe($questionState);
    expect($newStateYes->getStateYes())
        ->toBe($newFood)
        ->toBeInstanceOf(FoodState::class);
    expect($newStateYes->getStateNo())
        ->toBe($stateYes)
        ->toBeInstanceOf(FoodState::class);
});

test('setParentState method', function () {
    $state = (new QuestionState('massa'))
        ->setStateYes(new FoodState('Comida1'))
        ->setStateNo(new FoodState('Comida2'));

    $stateYes = $state->getStateYes();
    expect($stateYes->getParentState())->toBe($state);

    $stateNo = $state->getStateNo();
    expect($stateNo->getParentState())->toBe($state);
});

test('setStateYes method', function () {
    $foodDescription = 'Comida';

    $state = (new QuestionState('massa'))
        ->setStateYes(new FoodState($foodDescription));

    $stateYes = $state->getStateYes();
    expect($stateYes)->toBeInstanceOf(FoodState::class);
    expect($stateYes->getDescription())->toBe($foodDescription);
});

test('setStateNo method', function () {
    $foodDescription = 'Comida';

    $state = (new QuestionState('massa'))
        ->setStateNo(new FoodState($foodDescription));

    $stateYes = $state->getStateNo();
    expect($stateYes)->toBeInstanceOf(FoodState::class);
    expect($stateYes->getDescription())->toBe($foodDescription);
});
