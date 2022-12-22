<?php

class RucksackReorg {

  private array|false $input;

  public function __construct() {
    $this->input = file("input/day-3-input.txt", FILE_IGNORE_NEW_LINES);

    if (!$this->input) {
      exit('could not open input file for reading');
    }
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

  public function getTotalPriority(bool $secondPart=false): int {
    if ($secondPart) {
      return $this->getTotalPriorityBadges();
    } else {
      return $this->getTotalPriorityDuplicates();
    }
  }
}

$instance = new RucksackReorg();

echo "Total Priority of duplicate items from all rucksacks is " . $instance->getTotalPriority() . PHP_EOL;
echo "Total Priority of badges from all groups is " . $instance->getTotalPriority(true) . PHP_EOL;
