<?php

namespace App\Helpers\Algorithm;

use Illuminate\Support\Facades\DB;

class BayesClassifier
{
  /**
   * Clasificador Bayesiano
   * Esta clasificador trabaja con probabilidades y frecuencias precalculadas las cuales se toman de las
   * tablas clasProbs en donde estan las probabilidades a priori de las clases y likelihood en donde se 
   * encuentran las probabilidades P(x_i | C) y las frecuencias.
   * Estas tablas se llenan con un seeder que se encuentra en config/database/seeds. En el archivo DatabaseSeeder
   * se encuentran los calculos con los que se calculan las probabilidades y frecuencias.
   */
  static protected $out;

  /**
   * Funcion clasificadora
   * @param [type] $tablename: nombre de la tabla en la cual se tomaran los datos para el algoritmo
   * @param [type] $element: el ejemplo que será clasificado
   * @param [type] $classColumn: nombre de la columna donde se encuentran las clases a predecir
   */
  public static function classify($tablename, $element, $classColumn)
  {
    self::$out = new \Symfony\Component\Console\Output\ConsoleOutput();
    $predictions = [];
    $classes = DB::table($tablename)
      ->select($classColumn)
      ->distinct()
      ->pluck($classColumn);

    // Se calcula la probabilidad de que los datos en $element pertenezcan a cada una de las clases
    for ($i = 0; $i < count($classes); $i++) {
      $predictions[$i] = BayesClassifier::predictClass($tablename, $element, $classes[$i]);
    }
    // Se busca la clase con mayor probabilidad
    $max = 0;
    $index = 0;
    for ($j = 0; $j < count($predictions); $j++) {
      if ($predictions[$j] >= $max) {
        $max = $predictions[$j];
        $index = $j;
      }
      self::$out->writeln($predictions[$j]);
      self::$out->writeln($classes[$j]);
    }
    return $classes[$index];
  }

  /**
   * Retorna la probabilidad de que los datos en $element pertenezcan a  $class
   * @param [type] $tablename: nombre de la tabla en la cual se tomaran los datos para el algoritmo
   * @param [type] $element: elemento que vamos a evaluar
   * @param [type] $class: categoria
   */
  private static function predictClass($tablename, $element, $class)
  {
    $n_features = count($element);
    $p_c = DB::table('classProbs')
      ->where('class', $class)
      ->pluck('probability');
    // Probabilidad a priori de P($class)  
    $probs = $p_c[0];
    // Se obtienen la probabilidad y la frecuencia precalculada de P($feature | $class) desde la base de datos
    foreach ($element as $feature) {
      $precompute_probs = DB::table('likelihood')
        ->select('instances', 'probability')
        ->where('p_feature_class', $feature . '_' . $class)
        ->where('tablename', $tablename)
        ->get();

      $probs *= $precompute_probs[0]->instances + $n_features * $precompute_probs[0]->probability / ($n_features + pow($precompute_probs[0]->probability, -1));
    }
    return $probs;
  }
}
