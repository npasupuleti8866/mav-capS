<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestorApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(/**
         * @param Blueprint $table
         */
            'investor_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('inv_first_name');
            $table->string('inv_last_name');
            $table->integer('user_id')->unsigned();
            $table->string('inv_identification_card_number');
            $table->date('inv_date_of_birth');
            $table->string('inv_gender');
            $table->string('inv_street');
            $table->string('inv_city');
            $table->string('inv_state');
            $table->bigInteger('inv_zipcode');
            $table->string('inv_country');
            $table->bigInteger('inv_phonenumber');
            $table->string('inv_identity');
            $table->boolean('inv_agree_terms')->default(0);
            $table->string('inv_income');
            $table->string('inv_net_worth');
            $table->bigInteger('inv_estimated_p2p');
            $table->string('inv_risk_tolerance');
            $table->string('inv_stock_market');
            $table->string('inv_bonds_notes');
            $table->string('inv_mutual_funds');
            $table->string('inv_sme_business');
            $table->string('inv_p2p_lending');
            $table->string('inv_app_status')->nullable();
            $table->timestamps();
        });
        Schema::table('investor_applications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investor_applications');
    }
}
