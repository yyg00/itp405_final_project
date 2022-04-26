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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropColumns('comments', ['user_id']);
        Schema::dropColumns('favorites_by_users', ['user_id']);
        Schema::dropColumns('recipes', ['user_id']);
        // if (Schema::hasColumn('comments', 'user_id')){
        //     Schema::dropColumns('comments', ['user_id']);
        // }
        // if (Schema::hasColumn('favorites_by_users', 'user_id')) {
        //     Schema::dropColumns('favorites_by_users', ['user_id']);
        // }
        // if (Schema::hasColumn('recipes', 'user_id')) {
        //     Schema::dropColumns('recipes', ['user_id']);
        // }
        Schema::dropIfExists('users');
    }
};
