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
            $table->bigInteger("category_id")->unsigned()->index();
            $table->foreign("category_id")->references("id")->on("category");
            $table->bigInteger("type_id")->unsigned()->index();
            $table->foreign("type_id")->references("id")->on("type");
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
