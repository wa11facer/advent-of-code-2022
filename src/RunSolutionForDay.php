<?php

namespace Wallfacer\AdventOfCode2022;

require 'vendor/autoload.php';

const DAYS_CLASSES_MAP = [
  '1' => 'Day1CalorieCounting',
  '2' => 'Day2RockPaperScissors',
  '3' => 'Day3RucksackReorg',
  '4' => 'Day4CampCleanup',
  '5' => 'Day5SupplyStacks',
  '6' => 'Day6TuningTrouble',
  '7' => 'Day7NoSpaceLeft',
  '8' => 'Day8TreetopTreeHouse',
];

if ($argc != 2) {
  echo 'Usage: php RunSolutionForDay.php \<day_number\>';
} elseif (is_numeric($argv[1]) && isset(DAYS_CLASSES_MAP[$argv[1]])) {
  $instance = new (__NAMESPACE__ . '\Solution\\' . DAYS_CLASSES_MAP[$argv[1]])();
  $instance->solve();
}
