<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceRangeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_range_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_categories_id')->constrained()->onDelete('cascade');
            $table->integer('row');
            $table->integer('column');
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reference_range_tables');
    }
}
