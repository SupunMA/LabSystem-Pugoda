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
            $table->enum('value_type', ['range', 'text', 'negpos']);
            $table->string('unit')->nullable();
            $table->enum('reference_type', ['none', 'minmax', 'table'])->default('none');
            $table->decimal('min_value', 10, 2)->nullable();
            $table->decimal('max_value', 10, 2)->nullable();
            $table->string('range_unit')->nullable();
            $table->integer('display_order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_categories');
    }
}
