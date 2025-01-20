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
$useTestInput = false;

foreach ($argv as $key => $scriptParam) {
  if (str_starts_with($scriptParam, '-d')) {
    $dayNumber = substr($scriptParam, 2);
    if (!is_numeric($dayNumber) || !isset(DAYS_CLASSES_MAP[$dayNumber])) {
      echo 'Invalid day number provided. Please provide a valid day number between 1 and 25.';
      exit;
    }
    continue;
  }

  if (in_array($scriptParam, ['--test', '-t'])) {
    $useTestInput = true;
    continue;
  }

  # ignore empty params (from PHPStorm) & argv[0]
  if (empty($scriptParam) || $key === 0) {
    continue;
  }

  echo HELP_MSG;
  exit;
}

$className = __NAMESPACE__ . '\\Solution\\' . DAYS_CLASSES_MAP[$dayNumber];
$reflectionClass = new \ReflectionClass($className);
$instance = $reflectionClass->newInstance($useTestInput);

$start = microtime(true);

$instance->solve();

$end = microtime(true);
echo 'Duration: ' . round($end - $start, 4) . ' seconds' . PHP_EOL;
