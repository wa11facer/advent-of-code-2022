<?php

namespace Advent22\Interface;

interface Advent22Solution {
  public function getInput(): array|string;

  public function solve(): void;
}
