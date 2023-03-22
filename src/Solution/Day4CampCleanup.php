<?php

namespace Wallfacer\AdventOfCode2022\Solution;

use Wallfacer\AdventOfCode2022\Interface\Advent22Solution;

require_once __DIR__ . '/../Interface/Advent22Solution.php';

class Day4CampCleanup implements Advent22Solution {
  private array|false $input;
  protected bool $useTestInput;

  public function __construct(bool $useTestInput) {
    $this->useTestInput = $useTestInput;
    $this->input = $this->getInput();
  }

  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-4-" . ($this->useTestInput ? 'test-' : '') . "input.txt", FILE_IGNORE_NEW_LINES);

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
    echo '# of assignment pairs in which one range fully contain the other: ' . $this->getNumberOfIncludedPairs() . PHP_EOL;

    #part 2
    echo '# of assignment pairs in which the ranges overlap: ' . $this->getNumberOfOverlappingPairs() . PHP_EOL;
  }
}
