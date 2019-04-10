<?php
/**
 * Отвечает за всё, связанное с "конфа катка" командой
 */ 
class BattleModule
{
  const MIN_CHANCE = 20;
  const MAX_CHANCE = 70;
  const BASE_CHANCE = 50;
  const WIN = 1;
  const LOSE = -1;
  const MMR_GAIN = 25;

  private $attacker;
  private $defender;
  private $mmrChange;

  public function __construct($attacker, $defender)
  {
    $this->attacker = UserFactory::getUser($attacker);
    $this->defender = UserFactory::getUser($defender);
  }

  public function attack()
  {
    $winChance = $this->determineWinrate();
    $roll = mt_rand(1, 100);
    $status = self::WIN;
    if ($roll < $winChance) {
      $status = self::LOSE;
    }
    $this->updateMmr($status);
    $text = $this->getText($status);
    return $text;
  }

  private function determineWinrate()
  {
    $attackerMmr = $this->attacker->getMmr();
    $defenderMmr = $this->defender->getMmr();

    $difference = $attackerMmr - $defenderMmr;
    $percentage = (int) ($difference / 100);

    $rate = self::BASE_CHANCE + $percentage;
    if (self::MIN_CHANCE > $rate) {
      $rate = self::MIN_CHANCE;
    }
    if (self::MAX_CHANCE < $rate) {
      $rate = self::MAX_CHANCE;
    }

    return $rate;
  }

  private function getText($status)
  {
    $texts = array(
      'LOSE' => array(
        '#attacker# вызвал #defender# на бой, но бой произошел с его губой гагага. Висаси!',
      ),
      'WIN' => array(
        '#attacker# решил катануть против #defender# и не прогадал, ведь 15 фепеес придало уверенности победе #attacker#. Ну и что ? Зато линукс не логает'
      )
    );
    $key = '';

    if ($status == self::WIN) {
      $key = 'WIN';
    }
    if ($status == self::LOSE) {
      $key = 'LOSE';
    }
    $random = array_rand($texts[$key]);
    $randomText = $texts[$key][$random];
    $replacements = array(
      'attacker' => $this->attacker->getName(),
      'defender' => $this->defender->getName()
    );
	$epilog = "\nРейтинг: " . $this->mmrChange;
    $text = $this->replacePlaceholders($randomText, $replacements) . $epilog;
    return $text;
  }

  private function updateMmr($status)
  {
    $change = $status * self::MMR_GAIN;
    if ($change > 0) {
      $this->mmrChange = '+' . $change;
    } else {
      $this->mmrChange = $change;
    }
    $mmrChange = $this->attacker->getMmr() + $change;
    $this->attacker->setMmr($mmrChange);
    $this->defender->setMmr((-1 * $mmrChange));
  }

  private function replacePlaceholders($text, $replacements)
  {
    foreach ($replacements as $key => $replace) {
      $search = '#' . $key . '#';
      $text = str_replace($search, $replace, $text);
    }
    return $text;
  }
}

/**
 * Не нужен в качестве фабрики, так как в рантайме могут существовать максимум два класса одновременно.
 * Был сделан в качестве фабрики в тестовых целях.
 */

class UserFactory
{
  private static $userPool = array();
  private static $isInitialized = false;

  private static function initialize()
  {
    if (self::$isInitialized === false) {
      self::$userPool = array(
        '1' => array(
          'name' => 'yuri',
          'mmr' => 7000
        ),
        '2' => array(
          'name' => 'dema',
          'mmr' => 2000
        )
      );
      self::$isInitialized = true;
    }
  }
  public static function getUser($id)
  {
    self::initialize();

    $name = self::$userPool[$id]['name'];
    $mmr = self::$userPool[$id]['mmr'];

    return new User($name, $mmr);
  }
}

/**
 * @deprecated: есть модуль User для этого.
 */
class User
{
  private $name;
  private $mmr;

  public function __construct($name, $mmr)
  {
    $this->name = $name;
    $this->mmr = $mmr;
  }

  public function getMmr()
  {
    return $this->mmr;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setMmr($newValue)
  {
    $this->mmr = $newValue;
  }
}

$object = new BattleModule(1, 2);
var_dump($object->attack());