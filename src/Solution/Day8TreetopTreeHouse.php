<?php

namespace Wallfacer\AdventOfCode2022\Solution;

use Wallfacer\AdventOfCode2022\Interface\Advent22Solution;

require_once __DIR__ . '/../Interface/Advent22Solution.php';

/**
 * https://adventofcode.com/2022/day/8
 */
class Day8TreetopTreeHouse implements Advent22Solution {
  private array|false $input;
  protected bool $useTestInput;

  public function __construct(bool $useTestInput) {
    $this->useTestInput = $useTestInput;
    $this->input = $this->getInput();
  }


  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-8-" . ($this->useTestInput ? 'test-' : '') . "input.txt", FILE_IGNORE_NEW_LINES);

    if (!$input) {
      exit('could not open aoc22-input file for reading');
    }

    return array_map(str_split(...), $input);
  }


  private function isVisible(int $rowNum, int $colNum): bool {
    return
      $rowNum * $colNum == 0
      ||
      $rowNum == count($this->input) - 1
      ||
      $colNum == count($this->input[$rowNum]) - 1
      ||
      (
        (
          ($colNum - $this->calcViewDistInDirection($rowNum, $colNum, 'left') == 0)
          && $this->input[$rowNum][0] < $this->input[$rowNum][$colNum]
        )
        ||
        (
          ($rowNum - $this->calcViewDistInDirection($rowNum, $colNum, 'up') == 0)
          && $this->input[0][$colNum] < $this->input[$rowNum][$colNum]
        )
        ||
        (
          ($this->calcViewDistInDirection($rowNum, $colNum, 'right') + $colNum == count($this->input[$rowNum]) - 1)
          && $this->input[$rowNum][count($this->input[$rowNum]) - 1] < $this->input[$rowNum][$colNum]
        )
        ||
        (
          ($this->calcViewDistInDirection($rowNum, $colNum, 'down') + $rowNum == count($this->input)- 1)
          && $this->input[count($this->input)- 1][$colNum] < $this->input[$rowNum][$colNum]
        )
      );
  }


  private function countVisibleTrees(): int {
    $visibleTrees = 0;
    foreach ($this->input as $rowNum => $rowContent) {
      foreach ($rowContent as $colNum => $treeHeight) {
        if ($this->isVisible($rowNum, $colNum)) {
          $visibleTrees++;
        }
      }
    }

    return $visibleTrees;
  }


  private function calcViewDistInDirection(int $rowNum, int $colNum, string $direction): int {
    $viewDist = 0;
    switch ($direction) {
      case 'left':
        for ($i = $colNum - 1; $i >= 0; $i--) {
          if ($this->input[$rowNum][$i] >= $this->input[$rowNum][$colNum]) {
            return $viewDist + 1;
          }
          $viewDist++;
        }
        break;

      case 'up':
        for ($i = $rowNum - 1; $i >= 0; $i--) {
          if ($this->input[$i][$colNum] >= $this->input[$rowNum][$colNum]) {
            return $viewDist + 1;
          }
          $viewDist++;
        }
        break;

      case 'right':
        for ($i = $colNum + 1; $i < count($this->input[$rowNum]); $i++) {
          if ($this->input[$rowNum][$i] >= $this->input[$rowNum][$colNum]) {
            return $viewDist + 1;
          }
          $viewDist++;
        }
        break;

      case 'down':
        for ($i = $rowNum + 1; $i < count($this->input); $i++) {
          if ($this->input[$i][$colNum] >= $this->input[$rowNum][$colNum]) {
            return $viewDist + 1;
          }
          $viewDist++;
        }
    }

    return $viewDist;
  }


  private function calcScenicScore(int $rowNum, int $colNum): int {
    return $this->calcViewDistInDirection($rowNum, $colNum, 'left')
      * $this->calcViewDistInDirection($rowNum, $colNum, 'up')
      * $this->calcViewDistInDirection($rowNum, $colNum, 'right')
      * $this->calcViewDistInDirection($rowNum, $colNum, 'down');
  }


  private function getMaxScenicScore(): int {
    $maxScenicScore = 0;
    foreach ($this->input as $rowNum => $rowContent) {
      foreach ($rowContent as $colNum => $treeHeight) {
        $scenicScore = $this->calcScenicScore($rowNum, $colNum);
        if ($scenicScore > $maxScenicScore) {
          $maxScenicScore = $scenicScore;
        }
      }
    }
    return $maxScenicScore;
  }

  public function solve(): void {
    #part 1
    echo 'There are ' . $this->countVisibleTrees() . ' visible trees' . PHP_EOL;

    #part 2
    echo 'The max scenic score from all trees is ' . $this->getMaxScenicScore() . PHP_EOL;
  }
}
