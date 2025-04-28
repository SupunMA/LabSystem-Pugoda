<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availableTest_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('availableTests_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['space', 'title', 'paragraph']);
            $table->text('content')->nullable(); // For titles and paragraphs
            $table->integer('display_order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('availableTest_elements');
    }
}
