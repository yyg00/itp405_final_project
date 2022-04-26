<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('recipe_name', 30);
            $table->integer('cooking_time');
            $table->integer('serving');
            // $table->string('cuisine', 20);
            $table->longText('ingredients', 256);
            $table->longText('directions', 512);
            $table->longText('notes', 256)->nullable();
            //$table->string('type', 20);
            $table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropColumns('comments', ['recipe_id']);
        // Schema::dropColumns('favorites_by_users', ['recipe_id']);
        // if (Schema::hasColumn('comments', 'recipe_id')){
        //     Schema::dropColumns('comments', ['recipe_id']);
        // }
        // if (Schema::hasColumn('favorites_by_users', 'recipe_id')) {
        //     Schema::dropColumns('favorites_by_users', ['recipe_id']);
        // }

        Schema::dropIfExists('recipes');
    }
};
