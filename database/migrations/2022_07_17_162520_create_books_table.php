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
            $table->bigIncrements('id')->unsigned()->index();
            $table->text('book_name');
            $table->integer('pages');
            $table->bigInteger("section_id")->unsigned()->index();
            $table->foreign("section_id")->references("id")->on("section");
            $table->bigInteger("level_id")->unsigned()->index();
            $table->foreign("level_id")->references("id")->on("level");
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
