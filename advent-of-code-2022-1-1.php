<?php

/**
 * https://adventofcode.com/2022/day/1
 */
class CalorieCounting {
  protected $input;
  public function __construct() {
    $this->input = fopen("input/1-1-input.txt", "r");
    if (!$this->input) {
      exit('could not open input file for reading');
    }
  }

  public function run(): int {
    $maxCalorieCount = $currentCalorieCount = 0;

    while (($line = fgets($this->input)) !== false) {
      $line = (int)$line;
      if ($line == 0) {
        if ($currentCalorieCount > $maxCalorieCount) {
          $maxCalorieCount = $currentCalorieCount;
        }
        $currentCalorieCount = 0;
      } else {
        $currentCalorieCount += $line;
      }
    }

    fclose($this->input);

    return $maxCalorieCount;
  }
}

$instance = new CalorieCounting();
echo "The most calories carried by an Elf are " . $instance->run();
