<?php

use Advent22\Interface\Advent22Solution;

require_once '../interface/Advent22Solution.php';

class CampCleanup implements Advent22Solution {

  private array|false $input;

  public function __construct() {
    $this->input = $this->getInput();
  }

  public function getInput(): array {
    $input = file("../../aoc22-input/day-4-input.txt", FILE_IGNORE_NEW_LINES);

    if (!$input) {
      exit('could not open aoc22-input file for reading');
    }

    return array_map(function ($value) { return explode('-', preg_replace('/,/', '-',$value)); }, $input);
  }

  private function isFirstIncludedInSecond(array $sections): bool {
    return $sections[0] >= $sections[2] && $sections[1] <= $sections[3];
  }

  private function isSecondIncludedInFirst(array $sections): bool {
    return $sections[0] <= $sections[2] && $sections[1] >= $sections[3];
  }

  private function getNumberOfIncludedPairs(): int {
    $count = 0;

    foreach ($this->input as $pair) {
      if ($this->isFirstIncludedInSecond($pair) || $this->isSecondIncludedInFirst($pair)) {
        $count++;
      }
    }

    return $count;
  }

  private function isOverlap(array $sections): bool {
    return ($sections[1] >= $sections[2] && $sections[0] <= $sections[2])
      || ($sections[3] >= $sections[0] && $sections[2] <= $sections[0]);
  }

  private function getNumberOfOverlappingPairs(): int {
    $count = 0;

    foreach ($this->input as $pair) {
      if ($this->isOverlap($pair)) {
        $count++;
      }
    }

    return $count;
  }

  public function solve(): void {
    #part 1
    echo $this->getNumberOfIncludedPairs() . PHP_EOL;

    #part 2
    echo $this->getNumberOfOverlappingPairs() . PHP_EOL;
  }
}

$instance = new CampCleanup();
$instance->solve();
