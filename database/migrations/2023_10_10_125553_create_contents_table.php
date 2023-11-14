<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->integer('content_type');
            $table->string('meta_tag',200)->nullable();
            $table->string('meta_description',300)->nullable();
            $table->string('keywords',300);
            $table->tinyInteger('is_active')->default(0);
            $table->longText('content');
            $table->tinyInteger('is_published')->default(0);
            $table->integer('created_by')->nullable();
            $table->tinyInteger('approved')->default(0);
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
        Schema::dropIfExists('contents');
    }
}
