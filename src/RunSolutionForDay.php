<?php

namespace Wallfacer\AdventOfCode2022;

require __DIR__ . '/../vendor/autoload.php';

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
const HELP_MSG = 'Usage: php RunSolutionForDay.php -d\<day_number\> [--test/-t]' . PHP_EOL;

if (!in_array($argc, [2, 3])) {
  echo HELP_MSG;
  exit;
}

$dayNumber = 0;
$useTestInput = FALSE;

foreach ($argv as $scriptParam) {
  if (str_starts_with($scriptParam, '-d')) {
    $dayNumber = substr($scriptParam, 2);
    if (!is_numeric($dayNumber) || !isset(DAYS_CLASSES_MAP[$dayNumber])) {
      echo 'Invalid day';
      exit;
    }
    continue;
  }

  if (in_array($scriptParam, ['--test', '-t'])) {
    $useTestInput = TRUE;
    continue;
  }

  # ignore empty params (from PHPStorm) & argv[0]
  if (empty($scriptParam) || $scriptParam == __FILE__) {
    continue;
  }

  echo HELP_MSG;
  exit;
}

$instance = new (__NAMESPACE__ . '\Solution\\' . DAYS_CLASSES_MAP[$dayNumber])($useTestInput);
$instance->solve();
