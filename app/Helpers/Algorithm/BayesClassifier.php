<?php

namespace App\Helpers\Algorithm;

use Illuminate\Support\Facades\DB;

class BayesClassifier
{

  static protected $out;

  public static function classify($tablename, $element, $classColumn)
  {
    self::$out = new \Symfony\Component\Console\Output\ConsoleOutput();
    $predictions = [];
    $classes = DB::table($tablename)
      ->select($classColumn)
      ->distinct()
      ->pluck($classColumn);
    for ($i = 0; $i < count($classes); $i++) {
      $predictions[$i] = BayesClassifier::predictClass($tablename, $element, $classes[$i]);
    }

    // Se busca la prediccion con mayor probabilidad
    $max = 0;
    $index = 0;
    for ($j = 0; $j < count($predictions); $j++) {
      if ($predictions[$j] >= $max) {
        $max = $predictions[$j];
        $index = $j;
      }
    }
    self::$out->writeln($index);
    return $classes[$index];
  }

  private static function predictClass($tablename, $element, $class)
  {
    $p_c = DB::table('classProbs')
      ->where('class', $class)
      ->pluck('probability');
    $probs = $p_c[0];
    foreach ($element as $feature) {
      $p_f_c = DB::table('likelihood')
        ->where('p_feature_class', $feature . '_' . $class)
        ->pluck('probability');  
      // self::$out->writeln($feature . '_' . $class);  
      // self::$out->writeln(count($p_f_c));  
      $p_f_c = count($p_f_c) == 0 ? 1 : $p_f_c[0]; 
      $probs *= $p_f_c;
    }
    return $probs;
  }
}
