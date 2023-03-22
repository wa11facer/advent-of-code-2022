<?php

namespace Wallfacer\AdventOfCode2022\Solution;

use Wallfacer\AdventOfCode2022\Interface\Advent22Solution;

require_once __DIR__ . '/../Interface/Advent22Solution.php';

class Day7NoSpaceLeft implements Advent22Solution {
  const MAX_FOLDER_SIZE = 100000;
  const TOTAL_DISK_SPACE = 70000000;
  const NEEDED_DISK_SPACE = 30000000;

  private array|false $input;
  private array $dirSizes = [];
  protected bool $useTestInput;


  public function __construct(bool $useTestInput) {
    $this->useTestInput = $useTestInput;
    $this->input = $this->getInput();
  }


  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-7-" . ($this->useTestInput ? 'test-' : '') . "input.txt", FILE_IGNORE_NEW_LINES);

    if (!$input) {
      exit('could not open aoc22-input file for reading');
    }

    return $input;
  }


  private function buildTree(array &$input): array {
    $fileSystemTree = [];

    foreach ($input as &$line) {
      array_shift($input);

      switch ($line) {
        case "$ ls":
        case str_starts_with($line, "dir "):
          break;
        case is_numeric(substr($line, 0, 1)):
          $fileInfo = explode(" ", $line);
          $fileSystemTree[$fileInfo[1]] = $fileInfo[0];
          break;
        case "$ cd ..":
          return $fileSystemTree;
        case str_starts_with($line, "$ cd "):
          $dirInfo = explode(" ", $line);
          $fileSystemTree[$dirInfo[2]] = $this->buildTree($input);
          break;
      }
    }

    return $fileSystemTree;
  }


  private function calcDirSizes(array &$input, string $currentDirName = NULL): int {
    $currentDirSize = 0;

    # to differentiate between folders with the same name
    if (!empty($currentDirName)) {
      $currentDirName .= '_' . rand(0,10000);
    }

    foreach ($input as &$line) {
      array_shift($input);

      switch ($line) {
        case "$ ls":
        case str_starts_with($line, "dir "):
          break;
        case is_numeric(substr($line, 0, 1)):
          $fileInfo = explode(" ", $line);
          $currentDirSize += (int)$fileInfo[0];
          break;
        case "$ cd ..":
          if (empty($this->dirSizes[$currentDirName])) {
            $this->dirSizes[$currentDirName] = $currentDirSize;
            return $currentDirSize;
          } else {
            return $this->dirSizes[$currentDirName];
          }
        case str_starts_with($line, "$ cd "):
          $dirInfo = explode(" ", $line);
          if (empty($this->dirSizes[$currentDirName]) && !empty($currentDirName)) {
            $this->dirSizes[$currentDirName] = $currentDirSize;
          }
          $subDirSize = $this->calcDirSizes($input, $dirInfo[2]);
          if (!empty($currentDirName)) {
            $this->dirSizes[$currentDirName] += $subDirSize;
          }
          break;
      }
    }

    if (!empty($currentDirName)) {
      if (empty($this->dirSizes[$currentDirName])) {
        $this->dirSizes[$currentDirName] = $currentDirSize;
      }
      return $this->dirSizes[$currentDirName];
    }
    return $currentDirSize;
  }


  private function calcTotal(): int {
    $totalSize = 0;
    foreach ($this->dirSizes as $dirName => $dirSize) {
      if ($dirSize <= self::MAX_FOLDER_SIZE) {
        $totalSize += $dirSize;
      }
    }
    return $totalSize;
  }


  private function getHowMuchSpaceToFree(): int {
    $totalUsedSpace = array_shift($this->dirSizes);
    $freeSpace = self::TOTAL_DISK_SPACE - $totalUsedSpace;
    $amountOfDiskSpaceToFree = self::NEEDED_DISK_SPACE - $freeSpace;

    return $amountOfDiskSpaceToFree > 0 ? $amountOfDiskSpaceToFree : 0;
  }


  private function getSizeofSmallestDirToDelete(int $amountOfDiskSpaceToFree): int {
    foreach ($this->dirSizes as $dirName => $dirSize) {
      if ($dirSize >= $amountOfDiskSpaceToFree) {
        $sizes[] = $dirSize;
      }
    }

    sort($sizes);

    return $sizes[0];
  }


  public function solve(): void {
    $inputCopy = $inputCopy2 = $this->input;
    $this->buildTree($inputCopy);
    $this->calcDirSizes($inputCopy2);

    # part 1
    echo 'Total size of folders under 100000 is ' . $this->calcTotal() . PHP_EOL;

    # part 2
    $amountOfDiskSpaceToFree = $this->getHowMuchSpaceToFree();

    echo 'Smallest directory that can be deleted to free enough space has the size '
      . $this->getSizeofSmallestDirToDelete($amountOfDiskSpaceToFree) . PHP_EOL;
  }
}
