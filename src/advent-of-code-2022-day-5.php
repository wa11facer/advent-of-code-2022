<?php

class SupplyStacks {

  private array|false $input;
  private array $supplyStack = [];

  public function __construct() {
    $this->input = file("../input/day-5-input.txt", FILE_IGNORE_NEW_LINES);

    if ( !$this->input) {
      exit('could not open input file for reading');
    }
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
          $this->supplyStack[$i - 3 * $aux][] = $line[$i];
        }
        $aux++;
      }

      array_shift($this->input);
    }
  }

  private function performMoves(): string {
    $orders = [];

    foreach($this->input as $key => $line) {
      $orders[$key] = preg_split('/[a-z ]+/', $line);
      array_shift($orders[$key]);
    }

    foreach ($orders as $order) {
      for ($i = 0; $i < $order[0]; $i++) {
        array_unshift($this->supplyStack[$order[2]], array_shift($this->supplyStack[$order[1]]));
      }
    }

    $answer = '';
    for ($i = 1; $i <= count($this->supplyStack); $i++) {
      $answer .= array_shift($this->supplyStack[$i]);
    }

    return $answer;
  }

  public function solve(): void {
    # part 1
    $this->getCurrentStacks();
    echo $this->performMoves();
  }

}

$instance = new SupplyStacks();
$instance->solve();
