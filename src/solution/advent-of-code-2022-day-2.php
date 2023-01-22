<?php

namespace Advent22\Solution;

use Advent22\Interface\Advent22Solution;

require_once __DIR__ . '/../interface/Advent22Solution.php';

class RockPaperScissors implements Advent22Solution {
  protected array|bool $input;

  const ELF_ROCK = 'A';
  const ELF_PAPER = 'B';
  const ELF_SCISSORS = 'C';
  const PLAYER_ROCK = 'X';
  const PLAYER_PAPER = 'Y';
  const PLAYER_SCISSORS = 'Z';
  const LOSS = 'X';
  const DRAW = 'Y';
  const WIN = 'Z';
  const SHAPE_POINTS = [
    self::PLAYER_ROCK => 1,
    self::PLAYER_PAPER => 2,
    self::PLAYER_SCISSORS => 3,
  ];
  const OUTCOME_PLAYER_WIN = [
    self::ELF_ROCK => self::PLAYER_PAPER,
    self::ELF_PAPER => self::PLAYER_SCISSORS,
    self::ELF_SCISSORS => self::PLAYER_ROCK
  ];
  const OUTCOME_PLAYER_LOSS = [
    self::ELF_ROCK => self::PLAYER_SCISSORS,
    self::ELF_PAPER => self::PLAYER_ROCK,
    self::ELF_SCISSORS => self::PLAYER_PAPER
  ];
  const OUTCOME_PLAYER_DRAW = [
    self::ELF_ROCK => self::PLAYER_ROCK,
    self::ELF_PAPER => self::PLAYER_PAPER,
    self::ELF_SCISSORS => self::PLAYER_SCISSORS
  ];
  const WIN_POINTS = 6;
  const DRAW_POINTS = 3;
  const LOSS_POINTS = 0;

  public function __construct() {
    $this->input = $this->getInput();
  }


  public function getInput(): array {
    $input = file(__DIR__ . "/../../aoc22-input/day-2-input.txt", FILE_IGNORE_NEW_LINES);

    $input = array_map(function ($value) {
      return explode(" ", $value);
    }, $input);

    if ( !$input) {
      exit('could not open aoc22-input file for reading');
    }

    return $input;
  }


  private function getOutcomePoints(string $elf, string $player): int {
    if (self::OUTCOME_PLAYER_WIN[$elf] == $player) {
      return self::WIN_POINTS;
    } elseif (self::OUTCOME_PLAYER_LOSS[$elf] == $player) {
      return self::LOSS_POINTS;
    }

    return self::DRAW_POINTS;
  }


  private function getShapeToPlay(string $elf_shape, string $outcome): string {
    return match ($outcome) {
      self::LOSS => self::OUTCOME_PLAYER_LOSS[$elf_shape],
      self::WIN => self::OUTCOME_PLAYER_WIN[$elf_shape],
      self::DRAW => self::OUTCOME_PLAYER_DRAW[$elf_shape],
      default => '',
    };
  }


  private function calculateScore(bool $secondPart = false): int {
    $totalScore = 0;

    foreach ($this->input as $line) {
      if ($secondPart) {
        $line[1] = $this->getShapeToPlay($line[0], $line[1]);
      }
      $totalScore += $this->getOutcomePoints($line[0], $line[1]);
      $totalScore += self::SHAPE_POINTS[$line[1]];
    }

    return $totalScore;
  }


  public function solve(): void {
    echo "Total Score: " . $this->calculateScore() . PHP_EOL;

    echo "Total Score 2nd part: " . $this->calculateScore(true) . PHP_EOL;
  }
}
