<?php

namespace Advent22\Solution;

use Advent22\Interface\Advent22Solution;

require_once __DIR__ . '/../interface/Advent22Solution.php';

class TuningTrouble implements Advent22Solution {
  private array|false $input;

  public function __construct() {
    $this->input = $this->getInput();
  }

  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-6-input.txt", FILE_IGNORE_NEW_LINES);

    if ( !$input) {
      exit('could not open aoc22-input file for reading');
    }

    return str_split($input[0]);
  }

  private function isArrayWithUniqueElements(array $chars): bool {
    return count($chars) == count(array_unique($chars));
  }

  private function findStartMarker(int $numberOfDistinctChars): int {
    $lastXChars = [];

    foreach ($this->input as $key => $character) {
      $lastXChars[] = $character;
      if ($key >= $numberOfDistinctChars) {
        array_shift($lastXChars);
      }

      if (count($lastXChars) == $numberOfDistinctChars && $this->isArrayWithUniqueElements($lastXChars)) {
        return $key + 1;
      }
    }

    return -1;
  }

  public function solve(): void {
    # part 1
    echo 'The first start-of-packet marker is complete after ' . $this->findStartMarker(4) . ' characters' . PHP_EOL;

    # part 2
    echo 'The first start-of-message marker is complete after ' . $this->findStartMarker(14) . ' characters' . PHP_EOL;
  }
}
