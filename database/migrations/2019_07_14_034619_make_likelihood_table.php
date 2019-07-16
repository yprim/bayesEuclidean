<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLikelihoodTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('likelihood', function (Blueprint $table) {
      $table->increments('id');
      $table->string('tablename');
      $table->string('p_feature_class')->unique();
      $table->double('probability');
      $table->integer('instances');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('likelihood');
  }
}
