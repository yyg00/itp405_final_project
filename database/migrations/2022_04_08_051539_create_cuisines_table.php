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
        Schema::create('cuisines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('cuisine_name');
        });
        Schema::table('recipes', function (Blueprint $table) {
          
            $table->foreignId('cuisine_id')->constrained();
        });
        $cuisines_name = [
            'American',
            'Chinese',
            'Italian',
            'French',
            'Japanese',
            'Thai',
            'Indian',
        ];

        foreach ($cuisines_name as $cuisine_name) {
            DB::table('cuisines')->insert([
                'cuisine_name' => $cuisine_name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('recipes', ['cuisine_id']);
        Schema::dropIfExists('cuisines');
    }
};
