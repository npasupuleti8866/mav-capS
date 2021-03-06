<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('loan_amount');
            $table->string('loan_title');
            $table->string('loan_purpose');
            $table->string('loan_duration');
            $table->string('created_by');
            $table->string('updated_by');
            $table->decimal('loan_interest_rate')->nullable();
            $table->string('loan_status')->nullable();
            $table->decimal('loan_funded_percent')->nullable();
            $table->decimal('loan_funded_amount')->nullable();
            $table->integer('business_owner_application_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('loans', function (Blueprint $table) {
            $table->foreign('business_owner_application_id')->references('id')->on('business_owner_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
