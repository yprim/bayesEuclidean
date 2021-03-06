<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   * 
   * @return void
   */
  public function run()
  {
    DatabaseSeeder::seedLearningStylesProbs();
    DatabaseSeeder::seedCampusProbs();
    DatabaseSeeder::seedGenderProbs();
    DatabaseSeeder::seedTypeStudentProbs();
    DatabaseSeeder::seedTypeProfessorProbs();
    DatabaseSeeder::seedNetworkProbs();
  }

  private function estimateLikelihoods($tablename, $features, $classes, $classColumn)
  {
    // Foreach class
    foreach ($classes as $class) {
      // Estimates P(C) of $class
      $total = count(DB::table($tablename)->get());
      $classInstances = count(
        DB::table($tablename)
          ->where($classColumn, $class)
          ->get()
      );

      $p_c = $classInstances / $total;
      DB::table('classProbs')->insert(
        [
          'tablename' => $tablename,
          'class' => $class,
          'probability' => $p_c
        ]
      );
      // Foreach feature
      foreach ($features as $feature) {
        // Estimates P($feature | $class) and saves it
        $feature_instances = DB::table($tablename)
          ->select($feature)
          ->distinct()
          ->pluck($feature);

        foreach ($feature_instances as $f) {
          $p_f_c = count(
            DB::table($tablename)
              ->where($feature, $f)
              ->where($classColumn, $class)
              ->get()
          );

          $f = is_numeric($f) ? round($f) : $f;

          try {
            DB::table('likelihood')->insert(
              [
                'tablename' => $tablename,
                'p_feature_class' => $f . '_' . $class,
                'instances' => $p_f_c,
                'probability' => 1 / count($feature_instances)
              ]
            );
          } catch (QueryException $e)  {}
        }
      }
    }
  }

  private function seedLearningStylesProbs()
  {
    // Learning styles
    $features = ['ec', 'or', 'ca', 'ea'];
    $classes = [
      'ACOMODADOR',
      'DIVERGENTE',
      'ASIMILADOR',
      'CONVERGENTE'
    ];
    DatabaseSeeder::estimateLikelihoods('learning_styles', $features, $classes, 'style');
  }

  private function seedCampusProbs()
  {
    $features = ['average', 'gender', 'style'];
    $classes = ['Paraiso', 'Turrialba'];
    DatabaseSeeder::estimateLikelihoods('students', $features, $classes, 'campus');
  }

  private function seedGenderProbs()
  {
    $features = ['style', 'campus', 'average'];
    $classes = ['M', 'F'];
    DatabaseSeeder::estimateLikelihoods('students', $features, $classes, 'gender');
  }

  private function seedTypeStudentProbs()
  {
    $features = ['campus', 'gender', 'average'];
    $classes = [
      'ACOMODADOR',
      'DIVERGENTE',
      'ASIMILADOR',
      'CONVERGENTE'
    ];
    DatabaseSeeder::estimateLikelihoods('students', $features, $classes, 'style');
  }

  private function seedTypeProfessorProbs()
  {
    $features = ['age', 'gender', 'experience', 'course_times', 'discipline', 'skills_using_pc', 'skills_using_web_tech', 'skills_using_web_sites'];
    $classes = ['Beginner', 'Intermediate', 'Advanced'];
    DatabaseSeeder::estimateLikelihoods('professors', $features, $classes, 'type');
  }

  private function seedNetworkProbs()
  {
    $features = ['reliability', 'net_links', 'capacity',  'cost'];
    $classes = ['A', 'B'];
    DatabaseSeeder::estimateLikelihoods('networks', $features, $classes, 'class');
  }
}
