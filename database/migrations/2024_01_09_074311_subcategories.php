<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subcategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id('sub_id');
            $table->string('SubCategoryName')->nullable();
            $table->float('SubCategoryRangeMin')->nullable();
            $table->float('SubCategoryRangeMax')->nullable();
            $table->string('Units')->nullable();
            $table->integer('AvailableTestID')->nullable();

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
        Schema::dropIfExists('subcategories');
    }
}