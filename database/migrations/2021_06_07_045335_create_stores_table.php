<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_name'); //Razon social
            $table->string('system', 100)->nullable(); //Sistema usado
            $table->string('tokencash_account', 10)->unique(); //Numero de telefono para la cuenta en tokencash
            $table->unsignedBigInteger('tokencash_node')->unique(); //ID del nodo del establecimiento en el dbm de tokencash
            $table->unsignedBigInteger('subgroup_id');
            $table->string('street')->nullable();
            $table->string('suburb')->nullable();
            $table->string('reference')->nullable();
            $table->unsignedBigInteger('municipality_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subgroup_id')->references('id')->on('sub_groups');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
