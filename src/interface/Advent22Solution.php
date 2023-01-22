<?php

namespace Advent22\Interface;

interface Advent22Solution {
  public function getInput(): mixed;

  public function solve(): void;
}
