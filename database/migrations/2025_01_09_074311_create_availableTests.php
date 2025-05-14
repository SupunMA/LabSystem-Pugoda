<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availableTests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specimen');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_internal')->default(1); // Add column for internal/external test with default value 1
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
        Schema::dropIfExists('availableTests');
    }
}
