<?php

namespace Advent22\Solution;

use Advent22\Interface\Advent22Solution;

require_once __DIR__ . '/../interface/Advent22Solution.php';


class SupplyStacks implements Advent22Solution {
  private array|false $input;
  private array $supplyStacks = [];
  private array $rearrangements = [];

  public function __construct() {
    $this->input = $this->getInput();
  }

  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-5-input.txt", FILE_IGNORE_NEW_LINES);

    if ( !$input) {
      exit('could not open aoc22-input file for reading');
    }

    return $input;
  }

  private function getCurrentStacks(): void {
    foreach ($this->input as $line) {
      if (is_numeric($line[1])) {
        array_shift($this->input);
        array_shift($this->input);
        break;
      }

      $line = str_split($line);
      $aux = 0;
      for ($i = 1; $i < count($line); $i += 4) {
        if ($line[$i] != ' ') {
          $this->supplyStacks[$i - 3 * $aux][] = $line[$i];
        }
        $aux++;
      }

      array_shift($this->input);
    }
  }

  private function getRearrangements(): void {
    foreach ($this->input as $key => $line) {
      $this->rearrangements[$key] = preg_split('/[a-z ]+/', $line);
      array_shift($this->rearrangements[$key]);
    }
  }

  private function performMoves1By1(array $supplyStacks): array {
    foreach ($this->rearrangements as $rearrangement) {
      for ($i = 0; $i < $rearrangement[0]; $i++) {
        array_unshift($supplyStacks[$rearrangement[2]], array_shift($supplyStacks[$rearrangement[1]]));
      }
    }

    return $supplyStacks;
  }

  private function performMovesAllAtOnce(array $supplyStacks): array {
    foreach ($this->rearrangements as $rearrangement) {
      for ($i = 0; $i < $rearrangement[0]; $i++) {
        $stacklessCrates[] = array_shift($supplyStacks[$rearrangement[1]]);
      }
      for ($i = 0; $i < $rearrangement[0]; $i++) {
        array_unshift($supplyStacks[$rearrangement[2]], array_pop($stacklessCrates));
      }
    }

    return $supplyStacks;
  }

  public function getAnswer(array $supplyStacks): string {
    $answer = '';
    for ($i = 1; $i <= count($supplyStacks); $i++) {
      $answer .= array_shift($supplyStacks[$i]);
    }

    return $answer;
  }

  public function solve(): void {
    $this->getCurrentStacks();
    $this->getRearrangements();

    # part 1
    $modifiedSupplyStacks = $this->performMoves1By1($this->supplyStacks);
    echo 'After moving them 1-by-1, the following crates are on top of the stacks: '
      . $this->getAnswer($modifiedSupplyStacks) . PHP_EOL;

    # part 2
    $modifiedSupplyStacks = $this->performMovesAllAtOnce($this->supplyStacks);
    echo 'After moving them all at once, the following crates are on top of the stacks: '
      . $this->getAnswer($modifiedSupplyStacks) . PHP_EOL;
  }
}
