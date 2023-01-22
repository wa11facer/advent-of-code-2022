<?php

namespace Advent22;

foreach (scandir(__DIR__ . '/solution') as $filename) {
  $path = __DIR__ . '/solution/' . $filename;
  if (is_file($path)) {
    require $path;
  }
}

const DAYS_CLASSES_MAP = [
  '1' => 'CalorieCounting',
  '2' => 'RockPaperScissors',
  '3' => 'RucksackReorg',
  '4' => 'CampCleanup',
  '5' => 'SupplyStacks',
  '6' => 'TuningTrouble',
  '7' => 'NoSpaceLeft',
  '8' => 'TreetopTreeHouse',
];

if ($argc != 2) {
  echo 'Usage: php RunSolutionForDay.php \<day_number\>';
} elseif (is_numeric($argv[1]) && isset(DAYS_CLASSES_MAP[$argv[1]])) {
  $instance = new ('Advent22\Solution\\' . DAYS_CLASSES_MAP[$argv[1]])();
  $instance->solve();
}
