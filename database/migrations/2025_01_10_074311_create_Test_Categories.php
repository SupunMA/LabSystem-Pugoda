<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('availableTests_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('value_type', ['number', 'text', 'negpos', 'negpos_with_Value', 'getFromMindray', 'dropdown','formula']);
            // Add a new column to track if unit is enabled
            $table->boolean('unit_enabled')->default(false);
            $table->string('unit')->nullable();

            $table->string('value_type_Value')->nullable();// 'getFromMindray', 'dropdown','formula' values

            $table->enum('reference_type', ['none', 'minmax', 'table'])->default('none');
            $table->decimal('min_value', 10, 2)->nullable();
            $table->decimal('max_value', 10, 2)->nullable();
            // Range unit is removed as per requirements
            $table->integer('display_order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_categories');
    }
}
