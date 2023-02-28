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
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('title')->comment('Title');
            $table->string('author')->comment('Author');
            $table->string('genre')->comment('Genre');
            $table->string('description')->comment('Description');
            $table->string('isbn')->nullable()->comment('ISBN')->default(0);
            $table->string('image')->nullable()->comment('Image')->default('placeholder.png');
            $table->date('published')->comment('Published Date');
            $table->string('publisher')->comment('Publisher Name');
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
        Schema::dropIfExists('books');
    }
};
