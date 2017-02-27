<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessOwnerApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_owner_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bo_first_name');
            $table->string('bo_last_name');
            $table->string('bo_identification_card_number');
            $table->date('bo_date_of_birth');
            $table->string('bo_gender');
            $table->string('bo_personal_street');
            $table->string('bo_personal_city');
            $table->string('bo_personal_state');
            $table->integer('bo_personal_zipcode');
            $table->string('bo_personal_country');
            $table->integer('bo_personal_phonenumber');
            $table->string('bo_business_street');
            $table->string('bo_business_city');
            $table->string('bo_business_state');
            $table->integer('bo_business_zipcode');
            $table->string('bo_business_country');
            $table->integer('bo_business_phonenumber');
            $table->string('bo_industry');
            $table->string('bo_type');
            $table->string('bo_legal_entity');
            $table->string('bo_registration_number');
            $table->integer('bo_registration_year');
            $table->string('bo_court_judgement');
            $table->string('bo_bank_name');
            $table->string('bo_bank_account');
            $table->boolean('bo_agree_terms')->default(0);
            $table->boolean('bo_agree_fees')->default(0);
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
        Schema::dropIfExists('business_owner_applications');
    }
}