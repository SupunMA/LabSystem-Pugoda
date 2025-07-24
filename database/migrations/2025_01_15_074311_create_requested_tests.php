<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_tests', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->unsignedBigInteger('test_id'); // Foreign key to availableTests table
            $table->decimal('price', 10, 2); // Test price at the time of request
            $table->date('test_date'); // Date of the test
            $table->string('remark_id_or_customRemark')->nullable(); // when add custom remark or select from existing remarks

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('patient_id')->references('pid')->on('patients')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('availableTests')->onDelete('cascade');

            // Performance index for cleanup queries
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requested_tests');
    }
}
