<?php

namespace Advent22\Solution;

use Advent22\Interface\Advent22Solution;

require_once __DIR__ . '/../interface/Advent22Solution.php';

class RucksackReorg implements Advent22Solution {

  private array|false $input;

  public function __construct() {
    $this->input = $this->getInput();
  }


  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-3-input.txt", FILE_IGNORE_NEW_LINES);

    if (!$input) {
      exit('could not open aoc22-input file for reading');
    }

    return $input;
  }


  private function getDuplicateType(string $firstCompartment, string $secondCompartment): string {
    for ($i = 0; $i < strlen($firstCompartment); $i++) {
      if (str_contains($secondCompartment, $firstCompartment[$i])) {
        return $firstCompartment[$i];
      }
    }

    return '';
  }


  private function getItemPriority(string $duplicateType): int {
    $ascii_value = ord($duplicateType);
    return ord($duplicateType) > 90 ? $ascii_value - 96 : $ascii_value - 38;
  }


  private function getTotalPriorityBadges(): int {
    $totalPriority = $count = 0;

    foreach ($this->input as $rucksack) {
      $count++;
      $group[$count%3] = $rucksack;
      if ($count % 3 == 0) {
        for ($i = 0; $i < strlen($group[0]); $i++) {
          if (str_contains($group[1], $group[0][$i]) && str_contains($group[2], $group[0][$i])) {
            $totalPriority += $this->getItemPriority($group[0][$i]);
            break;
          }
        }
        $group = [];
      }
    }

    return $totalPriority;
  }


  private function getTotalPriorityDuplicates(): int {
    $totalPriority = 0;

    foreach ($this->input as $rucksack) {
      [$firstCompartment, $secondCompartment] = str_split($rucksack, strlen($rucksack)/2);

      $duplicate = $this->getDuplicateType($firstCompartment, $secondCompartment);
      if (empty($duplicate)) {
        exit('no duplicate found, something is wrong');
      }

      $totalPriority += $this->getItemPriority($duplicate);
    }

    return $totalPriority;
  }


  public function solve(): void {
    echo "Total Priority of duplicate items from all rucksacks is " . $this->getTotalPriorityBadges() . PHP_EOL;

    echo "Total Priority of badges from all groups is " . $this->getTotalPriorityDuplicates() . PHP_EOL;
  }
}
