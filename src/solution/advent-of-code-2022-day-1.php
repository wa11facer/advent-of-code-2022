<?php

/**
 * https://adventofcode.com/2022/day/1
 */
class CalorieCounting {
  protected mixed $input;
  public function readInput(): void {
    $this->input = fopen("../input/day-1-input.txt", "r");
    if (!$this->input) {
      exit('could not open input file for reading');
    }
  }

  public function findTopCount(int $howMany): int {
    $this->readInput();
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
}

$instance = new CalorieCounting();
echo "The most calories carried by an Elf are " . $instance->findTopCount(1) . PHP_EOL;
echo "The total calories carried by the 3 Elves with the most calories is " . $instance->findTopCount(3);
