<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_test_id'); // Foreign key to requested_tests
            $table->unsignedBigInteger('category_id'); // Foreign key to test_categories
            $table->text('result_value'); // Store the result (can handle text, numeric, pos/neg)
            $table->unsignedBigInteger('added_by'); // User who added the result
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('requested_test_id')->references('id')->on('requested_tests')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('test_categories')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

            // Performance index for faster lookups
            $table->index('requested_test_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
