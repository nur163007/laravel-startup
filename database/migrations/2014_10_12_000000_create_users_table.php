<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('username')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->integer('role')->default(3);
            $table->string('dob')->nullable();
            $table->string('company')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('nid')->nullable();
            $table->string('passport')->nullable();
            $table->string('password');
            $table->boolean('mobileverified')->default(0);
            $table->boolean('emailverified')->default(0);
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('state')->nullable();
            $table->string('country');
            $table->rememberToken();
            $table->integer('expired_in');
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
        Schema::dropIfExists('users');
    }
}
