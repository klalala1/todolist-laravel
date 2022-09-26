<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserregTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userreg', function (Blueprint $table) {
            $table->id();
            $table->rememberToken();
            $table->string('username', 16)->unique();
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->string('password_salt', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userreg');
    }
}
