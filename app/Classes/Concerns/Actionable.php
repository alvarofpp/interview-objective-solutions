<?php

namespace App\Classes\Concerns;

trait Actionable
{
    abstract public function action(): void;
}
