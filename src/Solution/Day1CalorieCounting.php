<?php

namespace Wallfacer\AdventOfCode2022\Solution;

use Wallfacer\AdventOfCode2022\Interface\Advent22Solution;

require_once __DIR__ . '/../Interface/Advent22Solution.php';

class Day1CalorieCounting implements Advent22Solution {
  protected mixed $input = [];

  public function getInput(): mixed {
    $input = fopen(__DIR__ . "/../../aoc22-input/day-1-input.txt", "r");

    if (!$input) {
      exit('could not open aoc22-input file for reading');
    }

    return $input;
  }


  private function findTopCount(int $howMany): int {
    $currentCalorieCount = 0;
    $topCalorieCount = [0];

    while (($line = fgets($this->input)) !== false) {
      $line = (int)$line;
      if ($line == 0) {
        if ($currentCalorieCount > $topCalorieCount[0]) {
          if (count($topCalorieCount) == $howMany) {
            $topCalorieCount[0] = $currentCalorieCount;
          } else {
            $topCalorieCount[] = $currentCalorieCount;
          }
          sort($topCalorieCount);
        }
        $currentCalorieCount = 0;
      } else {
        $currentCalorieCount += $line;
      }
    }

    fclose($this->input);

    return array_sum($topCalorieCount);
  }


  public function solve(): void {
    $this->input = $this->getInput();
    echo "The most calories carried by an Elf are " . $this->findTopCount(1) . PHP_EOL;

    $this->input = $this->getInput();
    echo "The total calories carried by the 3 Elves with the most calories is " . $this->findTopCount(3) . PHP_EOL;
  }
}

