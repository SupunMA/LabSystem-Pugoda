<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_paths', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('requested_test_id'); // Foreign key to requested_tests table
            $table->string('file_path'); // Path to the uploaded file
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraint
            $table->foreign('requested_test_id')->references('id')->on('requested_tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_paths');
    }
}
