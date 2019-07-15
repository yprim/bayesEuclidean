<?php

namespace App\Helpers\Algorithm;

class Euclidean
{
  /**
   * Performs the Euclidean distance calculation algorithm.
   * 
   * Takes the point of the vectorX and compare it with each of the points of
   * the vectorY to obtain the nearest point and therefore the value of that point.
   * 
   * @param array $vectorX Point to compare the least distance.
   * @param array $vectorY Records to calculate the point closest to the point
   *                       of the vectorX.
   * @return string $result Value of the closest point.
   */

  static protected $features_to_numbers = [
    'Beginner' => 1,
    'Intermediate' => 2,
    'Advanced' => 3,
    'DM' => 1,
    'ND' => 2,
    'O' => 3,
    'NA' => 3,
    'F' => 1,
    'M' => 2,
    'Paraiso' => 1,
    'Turrialba' => 2,
    'Low' => 1,
    'L' => 1,
    'Medium' => 2,
    'High' => 3,
    'N' => 1,
    'B' => 1,
    'CONVERGENTE' => 1,
    'DIVERGENTE' => 2,
    'ACOMODADOR' => 3,
    'ASIMILADOR' => 4,
    'I' => 2,
    'S' => 2,
    'A' => 3,
    'H' => 3
  ];

  protected static function convert_to_number($value) {
    return isset(self::$features_to_numbers[$value]) ?
       self::$features_to_numbers[$value] : $value;
  }

  public static function euclidean($vectorX, $vectorY)
  {
    $min = $result = 1000;

    foreach ($vectorY as $current) {
      $value = 0;
      $current = array_values((array) $current);

      for ($i = count($vectorX) - 1; $i >= 0; $i--) {
        $value += pow( Euclidean::convert_to_number($vectorX[$i]) - Euclidean::convert_to_number($current[$i]), 2);
      }

      $value = sqrt($value);

      if ($min == 0)
        return end($current);
      else
        if ($min > $value) {
        $min = $value;
        $result = end($current);
      }
    }
    return $result;
  }
}
