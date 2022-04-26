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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type_name');
        });
        Schema::table('recipes', function (Blueprint $table) {
          
            $table->foreignId('type_id')->constrained();
        });
        $types_name = [
            'Breakfast',
            'Brunch',
            'Lunch',
            'Dinner',
            'Dessert',
        ];

        foreach ($types_name as $type_name) {
            DB::table('types')->insert([
                'type_name' => $type_name,
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
        Schema::dropColumns('recipes', ['type_id']);
        Schema::dropIfExists('types');
    }
};
