<?php

class CampCleanup {

  private array|false $input;

  public function __construct() {
    $this->input = file("input/day-4-input.txt", FILE_IGNORE_NEW_LINES);
    $this->input = array_map(function ($value) { return explode('-', preg_replace('/,/', '-',$value)); }, $this->input);

    if (!$this->input) {
      exit('could not open input file for reading');
    }
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

  private function getNumberOfOverlappingPairs() {
  }

  public function solve(): void {
    #part 1
    echo $this->getNumberOfIncludedPairs();

    $this->getNumberOfOverlappingPairs();
  }
}

$instance = new CampCleanup();
$instance->solve();
